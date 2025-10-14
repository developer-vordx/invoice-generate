<?php

namespace App\Http\Controllers;

use App\Mail\SendInvoiceMail;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Jobs\SendInvoiceEmail;
use Stripe\StripeClient;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch invoices with related customer data and paginate (10 per page)
        $invoices = Invoice::with('customer:id,name,company_name')->paginate(10);

        // Return view with paginated data
        return view('invoices.index', compact('invoices'));
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
                'issue_date' => $request->input('issue_date'),
                'due_date' => $request->input('due_date'),
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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);

        $invoice->subtotal = $invoice->items->sum(fn($item) => $item->quantity * $item->unit_price);
        $invoice->taxRate = 0.1;
        $invoice->taxAmount = $invoice->subtotal * $invoice->taxRate;
        $invoice->total = $invoice->subtotal + $invoice->taxAmount;

        $invoice->status_color = match ($invoice->status) {
            'sent' => 'bg-blue-100 text-blue-600',
            'paid' => 'bg-green-100 text-green-600',
            'void' => 'bg-red-100 text-red-600',
            default => 'bg-gray-100 text-gray-600',
        };

        return view('invoices.show', compact('invoice'));
    }


    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            $invoices = Invoice::with('customer')
                ->when($query, function ($q) use ($query) {
                    $q->where('invoice_number', 'like', "%{$query}%")
                        ->orWhereHas('customer', function ($q2) use ($query) {
                            $q2->where('name', 'like', "%{$query}%");
                        })
                        ->orWhere('status', 'like', "%{$query}%");
                })
                ->orderBy('issue_date', 'desc')
                ->limit(25)
                ->get();

            $data = $invoices->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'customer_name' => $invoice->customer->name ?? 'N/A',
                    'amount' => number_format($invoice->amount, 2),
                    'status' => $invoice->status,
                    'issue_date_formatted' => optional($invoice->issue_date)->format('M d, Y'),
                    'due_date_formatted' => optional($invoice->due_date)->format('M d, Y'),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Invoice search failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'query' => $request->input('query'),
            ]);

            // Return a JSON error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching invoices.',
                'error' => config('app.debug') ? $e->getMessage() : null, // Optional: show detailed error only in debug mode
            ], 500);
        }
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

    /**
     * Download invoice as PDF.
     */

    public function downloadPdf(Invoice $invoice, Request $request)
    {
        try {
            // Generate PDF from the invoice Blade view
            $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

            // If AJAX request, return base64-encoded PDF
            if ($request->ajax()) {
                $pdfContent = $pdf->output();
                $fileName = 'invoice-' . $invoice->invoice_number . '.pdf';

                return response()->json([
                    'success' => true,
                    'fileName' => $fileName,
                    'fileData' => base64_encode($pdfContent),
                    'message' => 'Invoice PDF generated successfully.'
                ]);
            }

            // Otherwise, normal download
            return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send invoice email with PDF attachment.
     */
    public function sendInvoiceEmail($id)
    {
        $invoice = Invoice::with(['customer', 'items'])->findOrFail($id);

        try {
            Mail::to($invoice->customer->email)->send(new SendInvoiceMail($invoice));

            return response()->json([
                'success' => true,
                'message' => 'Invoice email sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send invoice email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Void invoice (and optionally cancel on Stripe).
     */
    public function void(Invoice $invoice)
    {
        $invoice->status = 'void';
        $invoice->save();

        // If Stripe integration
        if ($invoice->stripe_invoice_id ?? false) {
            $stripe = new StripeClient(config('services.stripe.secret'));
            $stripe->invoices->voidInvoice($invoice->stripe_invoice_id);
        }

        return response()->json(['message' => 'Invoice voided successfully.']);
    }

    public function reports(Request $request)
    {

        $query = Invoice::with('customer');

        if ($request->filled('start_date')) {
            $query->whereDate('issue_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('issue_date', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->paginate(10);

        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $unpaidInvoices = Invoice::where('status', 'unpaid')->count();
        $outstanding = Invoice::where('status', 'unpaid')->sum('amount');

        // Chart data (monthly totals)
        $chartLabels = Invoice::selectRaw('MONTHNAME(issue_date) as month')
            ->groupBy('month')->pluck('month');

        $chartData = Invoice::selectRaw('SUM(amount) as total')
            ->groupByRaw('MONTH(issue_date)')
            ->pluck('total');

        return view('invoices.reports', compact(
            'invoices', 'totalInvoices', 'paidInvoices', 'unpaidInvoices', 'outstanding',
            'chartLabels', 'chartData'
        ));
    }

}
