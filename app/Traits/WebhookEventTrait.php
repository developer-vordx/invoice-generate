<?php

namespace App\Traits;

use App\Jobs\SendWebhookNotification;

trait WebhookEventTrait
{
    public static function bootWebhookEventTrait()
    {
        static::created(function ($model) {
            $event = strtolower(class_basename($model)) . '.created';
            SendWebhookNotification::dispatch($event, self::buildPayload($model));
        });

        static::updated(function ($model) {
            $event = strtolower(class_basename($model)) . '.updated';
            SendWebhookNotification::dispatch($event, self::buildPayload($model));
        });

        static::deleted(function ($model) {
            $event = strtolower(class_basename($model)) . '.deleted';
            SendWebhookNotification::dispatch($event, self::buildPayload($model));
        });
    }

    /**
     * Build the webhook payload.
     */
    protected static function buildPayload($model): array
    {
        $payload = $model->toArray();

        // Include invoice items if they exist
        if (method_exists($model, 'items')) {
            $payload['items'] = $model->items()->get()->toArray();
        }

        return $payload;
    }
}
