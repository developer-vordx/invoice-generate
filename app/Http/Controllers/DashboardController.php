<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ Stats
        $totalInvoices = Invoice::count();
        $totalPayments = Invoice::where('status', 'paid')->count();
        $unmatchedPayments = Invoice::where('status', 'unpaid')->count();

        // Calculate total revenue (sum of paid invoices)
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->with('items')
            ->get()
            ->flatMap(fn($invoice) => $invoice->items)
            ->sum(fn($item) => $item->amount * $item->quantity);

        // ✅ Charts
        $revenueData = Invoice::select(
            DB::raw('MONTHNAME(issue_date) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->groupBy('month')
            ->orderBy(DB::raw('MONTH(issue_date)'))
            ->get();

        $chartLabels = $revenueData->pluck('month');
        $chartValues = $revenueData->pluck('total');

        // Invoice status distribution
        $paidCount = Invoice::where('status', 'sent')->count();
        $pendingCount = Invoice::where('status', 'sent')->count();
        $overdueCount = Invoice::where('status', 'unpaid')->count();

        return view('dashboard.index', compact(
            'totalInvoices',
            'totalPayments',
            'unmatchedPayments',
            'monthlyRevenue',
            'chartLabels',
            'chartValues',
            'paidCount',
            'pendingCount',
            'overdueCount'
        ));
    }
}
