<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        // ✅ Load the dynamic webhook secret from settings (via SettingServiceProvider)
        $endpointSecret = config('settings.stripe_webhook_secret');

        if (!$endpointSecret) {
            Log::error('Stripe webhook secret not configured.');
            return response('Stripe webhook secret not configured', 500);
        }

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Invalid Stripe payload: ' . $e->getMessage());
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Invalid Stripe signature: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        // Handle event types
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;

            case 'invoice.payment_failed':
                $invoice = $event->data->object;
                $this->handlePaymentFailed($invoice);
                break;

            default:
                Log::info('Unhandled Stripe event type: ' . $event->type);
        }

        return response('Webhook handled', 200);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        // ✅ Payment success logic
        Log::info('Checkout session completed: ' . $session->id);

        // Example: find and mark your invoice as paid
        // $invoice = Invoice::where('stripe_session_id', $session->id)->first();
        // if ($invoice) {
        //     $invoice->status = 'paid';
        //     $invoice->save();
        // }
    }

    protected function handlePaymentFailed($invoice)
    {
        Log::warning('Payment failed for invoice: ' . $invoice->id);
    }
}
