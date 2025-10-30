<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceRejectedMail;

class InvoiceResponseController extends Controller
{
    public function respond(Request $request, Invoice $invoice)
    {
        $action = $request->query('action');

        // Save that the user responded
        $invoice->user_responded = now();
        $invoice->save();

        // ✅ 1. Already rejected
        if ($invoice->status === 'declined') {
            $invoice->logActivity('viewed_rejected', 'Customer viewed already rejected invoice.');
            return view('invoices.rejected', compact('invoice'));
        }

        // ✅ 2. Already paid / accepted
        if (in_array($invoice->payment_status, ['paid', 'completed'])) {
            $invoice->logActivity('viewed_paid', 'Customer viewed already paid invoice.');
            return redirect()
                ->route('invoices.show', $invoice->id)
                ->with('success', 'This invoice has already been paid.');
        }

        // ✅ 3. Handle “accept” action
        if ($action === 'accept') {
            // Already has a Stripe checkout — redirect there
            if (!empty($invoice->gateway_transaction_id) && !empty($invoice->gateway_response['url'])) {
                $invoice->logActivity('revisit_checkout', 'Customer revisited existing Stripe checkout session.');
                return redirect($invoice->gateway_response['url']);
            }

            // Calculate total
            $totalAmount = $invoice->items->sum(fn($item) => $item->quantity * $item->amount);

            // ✅ Use Stripe secret key
            $stripeSecret = config('settings.stripe_secret_key');
            if (!$stripeSecret) {
                abort(500, 'Stripe secret key not configured.');
            }
            \Stripe\Stripe::setApiKey($stripeSecret);

            // Create Stripe Checkout Session
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'USD',
                        'product_data' => [
                            'name' => "Invoice #{$invoice->invoice_number}",
                        ],
                        'unit_amount' => $totalAmount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $invoice->customer->email,
                'success_url' => route('invoices.show', $invoice->id) . '?paid=true',
                'cancel_url' => route('invoices.show', $invoice->id),
                'metadata' => [
                    'invoice_id' => $invoice->id,
                ],
            ]);

            // ✅ Save Stripe details
            $invoice->update([
                'payment_gateway'        => 'stripe',
                'gateway_transaction_id' => $session->id,
                'gateway_response'       => array_merge($session->toArray(), ['url' => $session->url]),
                'payment_status'         => 'pending',
                'status'                 => 'pending',
            ]);

            // ✅ Log activity
            $invoice->logActivity('accepted', 'Customer accepted invoice and started payment process via Stripe.');

            return redirect($session->url);
        }

        // ✅ 4. Handle “reject” action
        if ($action === 'reject') {
            if ($invoice->status !== 'declined') {
                $invoice->status = 'declined';
                $invoice->save();

                $invoice->logActivity('rejected', 'Customer rejected the invoice.');

                Mail::to('hamzagill451@gmail.com')->send(new InvoiceRejectedMail($invoice));
            } else {
                $invoice->logActivity('viewed_rejected', 'Customer viewed already rejected invoice.');
            }

            return view('invoices.rejected', compact('invoice'));
        }

        // Invalid action fallback
        $invoice->logActivity('invalid_action', "Customer tried invalid invoice action: {$action}");
        abort(404, 'Invalid action.');
    }

    public function rejected(Invoice $invoice)
    {
        $invoice->logActivity('viewed_rejected_page', 'Customer viewed rejected confirmation page.');
        return view('invoices.rejected', compact('invoice'));
    }

    public function success(Invoice $invoice)
    {
        $invoice->logActivity('viewed_success_page', 'Customer viewed success page after payment.');
        return view('invoices.success', compact('invoice'));
    }

    public function cancel(Invoice $invoice)
    {
        $invoice->logActivity('viewed_cancel_page', 'Customer canceled payment and viewed cancellation page.');
        return view('invoices.cancel', compact('invoice'));
    }
}
