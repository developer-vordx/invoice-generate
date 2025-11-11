<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WebhookSetting;

class SendWebhookNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $event;
    protected array $payload;

    public function __construct(string $event, array $payload)
    {
        $this->event = $event;
        $this->payload = $payload;
    }

    public function handle(): void
    {
        $setting = WebhookSetting::settings();

        if (!$setting || !$setting->webhook_url) {
            Log::warning("Webhook skipped — no webhook URL configured.");
            return;
        }

        // Map event -> setting flag
        $eventMap = [
            'customer.created' => $setting->enable_customer_create,
            'customer.updated' => $setting->enable_customer_update,
            'customer.deleted' => $setting->enable_customer_delete,

            'product.created'  => $setting->enable_product_create,
            'product.updated'  => $setting->enable_product_update,
            'product.deleted'  => $setting->enable_product_delete,

            'invoice.created'  => $setting->enable_invoice_create,
            'invoice.updated'  => $setting->enable_invoice_update,
            'invoice.deleted'  => $setting->enable_invoice_delete,
        ];

        // Skip if event disabled
        if (empty($eventMap[$this->event])) {
            Log::info("Webhook skipped for {$this->event} — event disabled.");
            return;
        }

        try {
            // Create signature (optional but recommended)
            $signature = hash_hmac('sha256', json_encode($this->payload), $setting->webhook_secret ?? 'secret');

            Http::withHeaders([
                'X-Webhook-Event' => $this->event,
                'X-Webhook-Signature' => $signature,
                'X-Webhook-Secret' => $setting->webhook_secret,
            ])->post($setting->webhook_url, [
                'event' => $this->event,
                'data' => $this->payload,
                'timestamp' => now()->toIso8601String(),
            ]);

            Log::info("Webhook sent successfully for {$this->event}");
        } catch (\Exception $e) {
            Log::error("Webhook failed for {$this->event}: {$e->getMessage()}", [
                'event' => $this->event,
                'url' => $setting->webhook_url,
            ]);
        }
    }
}
