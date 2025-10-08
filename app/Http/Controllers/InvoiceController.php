<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use PDF;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Jobs\SendInvoiceEmail;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Invoice::all();
        return view('invoices.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::latest()->first();
        return view('invoices.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice.issue_date',
            'currency' => 'required|string',
            'line_items.*.description' => 'required|string',
            'line_items.*.quantity' => 'required|numeric|min:1',
            'line_items.*.unit_price' => 'required|numeric|min:0',
        ]);

        \DB::beginTransaction();
        try {
            // ✅ Create or update customer
            $email = $request->input('email');
            $customer = Customer::updateOrCreate(
                ['email' => $email],
                ['name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'country' => $request->input('country')
                ]
            );

            // ✅ Create invoice
            $invoiceData = $request->input('invoice_number');
            $invoice = Invoice::create([
                'user_id' => auth()->id(),
                'customer_id' => $customer->id,
                'invoice_number' => $request->input('invoice_number'),
                'description' => $request->input('description')  ?? '',
                'amount' => 0, // will calculate after adding line items
                'status' => 'sent',
                'note' => $invoiceData['note'] ?? '',
            ]);

            // ✅ Create line items and calculate total
            $totalAmount = 0;
            foreach ($request->input('line_items') as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $invoice->items()->create([
                    'activity' => $item['description'],
                    'quantity' => $item['quantity'],
                    'amount' => $item['unit_price'],
                    'total' => $lineTotal,
                ]);
                $totalAmount += $lineTotal;
            }

            $invoice->update(['amount' => $totalAmount]);

            // ✅ Generate PDF
//            $pdf = PDF::loadView('invoices.pdf', compact('invoice'))->output();
//            $pdfPath = storage_path("app/invoices/{$invoice->invoice_number}.pdf");
//            file_put_contents($pdfPath, $pdf);

            // ✅ Stripe Checkout
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'USD',
                            'product_data' => [
                                'name' => "Invoice #{$invoice->invoice_number}",
                            ],
                            'unit_amount' => $totalAmount * 100,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('invoices.show', $invoice->id) . '?paid=true',
                'cancel_url' => route('invoices.show', $invoice->id),
            ]);

            // ✅ Dispatch Mail Job
            SendInvoiceEmail::dispatch($invoice, '', $session->url);

            \DB::commit();

            return response()->json([
                'message' => 'Invoice created successfully!',
                'invoice_id' => $invoice->id,
            ]);
        } catch (\Throwable $e) {
            \DB::rollBack();
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        return view('invoices.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
