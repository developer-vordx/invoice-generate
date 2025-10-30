<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe webhooks
     */
    public function handleWebhook(Request $request)
    {
        // ✅ Get the webhook secret dynamically from global settings
        $globalSettings = view()->shared('globalSettings');

        if (!$globalSettings || empty($globalSettings->webhook_secret)) {
            Log::error('Stripe webhook secret not found in global settings.');
            return response('Webhook secret not configured', 500);
        }

        $endpointSecret = $globalSettings->webhook_secret;
        $payload = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $event = null;

        try {
            // ✅ Verify signature
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        }

        // ✅ Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                // Try to find the invoice by metadata or by transaction ID
                $invoice = null;

                if (!empty($session->metadata->invoice_id)) {
                    $invoice = Invoice::find($session->metadata->invoice_id);
                }

                if (!$invoice && !empty($session->id)) {
                    $invoice = Invoice::where('gateway_transaction_id', $session->id)->first();
                }

                if ($invoice) {
                    // ✅ Update invoice status
                    $invoice->update([
                        'payment_status'         => 'paid',
                        'status'                 => 'paid',
                        'gateway_transaction_id' => $session->id,
                        'gateway_response'       => $session->toArray(),
                    ]);

                    $invoice->logActivity(
                        'payment_success',
                        "Payment completed successfully via Stripe. Transaction ID: {$session->id}"
                    );

                    // (Optional) Send confirmation email to admin or customer
                    // Mail::to($invoice->customer->email)->send(new InvoicePaidMail($invoice));
                } else {
                    Log::warning('No matching invoice found for Stripe session.', [
                        'session_id' => $session->id,
                    ]);
                }

                break;

            default:
                Log::info('Unhandled Stripe event type.', ['type' => $event->type]);
        }

        return response('Webhook received', 200);
    }
}
