<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceRejectedMail;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class InvoiceResponseController extends Controller
{
    public function respond(Request $request, Invoice $invoice)
    {
        $action = $request->query('action');

        // Store that user has responded and save their email
        $invoice->user_responded = now();
        $invoice->save();

        if ($action === 'accept') {
            // Calculate total amount from invoice items
            $totalAmount = 0;
            foreach ($invoice->items as $item) { // iterate collection properly
                $lineTotal = $item->quantity * $item->amount;
                $totalAmount += $lineTotal;
            }

            // Initialize Stripe
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            // Create Stripe Checkout session
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'USD',
                        'product_data' => [
                            'name' => "Invoice #{$invoice->invoice_number}",
                        ],
                        'unit_amount' => $totalAmount * 100, // Stripe expects cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $invoice->customer->email, // prefill email
                'success_url' => route('invoices.show', $invoice->id) . '?paid=true',
                'cancel_url' => route('invoices.show', $invoice->id),
            ]);

            // Redirect user to Stripe Checkout
            return redirect($session->url);
        }

        if ($action === 'reject') {
            // Mark invoice as rejected
            $invoice->status = 'declined';
            $invoice->save();

            // Notify admin about rejection
            Mail::to('hamzagill451@gmail.com')->send(new InvoiceRejectedMail($invoice));

            // Redirect to a rejection confirmation page
            return view('invoices.rejected', compact('invoice'));
        }

        // Invalid action fallback
        abort(404, 'Invalid action.');
    }

    public function rejected(Invoice $invoice)
    {
        return view('invoices.rejected', compact('invoice'));
    }

    public function success(Invoice $invoice)
    {
        return view('invoices.success', compact('invoice'));
    }

    public function cancel(Invoice $invoice)
    {
        return view('invoices.cancel', compact('invoice'));
    }

}

