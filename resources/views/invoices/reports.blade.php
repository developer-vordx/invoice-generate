@extends('layouts.auth.app')

@section('title', 'Invoice Reports - ReconX')

@section('content')
    <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Invoice Reports</h2>
    </header>

    <main class="p-8 space-y-8">

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
                <p class="text-gray-500 text-sm">Total Invoices</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalInvoices ?? 0 }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
                <p class="text-gray-500 text-sm">Paid Invoices</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $paidInvoices ?? 0 }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
                <p class="text-gray-500 text-sm">Unpaid Invoices</p>
                <h3 class="text-2xl font-bold text-red-600">{{ $unpaidInvoices ?? 0 }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
                <p class="text-gray-500 text-sm">Outstanding Balance</p>
                <h3 class="text-2xl font-bold text-blue-600">${{ number_format($outstanding ?? 0, 2) }}</h3>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <form method="GET" action="{{ route('reports') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">All</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-filter mr-2"></i>Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Chart Section -->
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Invoice Summary</h3>
            <canvas id="invoiceChart" height="120"></canvas>
        </div>

        <!-- Data Table -->
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100 overflow-x-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Detailed Report</h3>
                <a href="{{ route('reports') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-file-excel mr-2"></i>Export CSV
                </a>
            </div>

            <table class="min-w-full text-sm text-gray-700">
                <thead>
                <tr class="border-b bg-gray-50 text-left text-gray-600">
                    <th class="py-3 px-4">Invoice #</th>
                    <th class="py-3 px-4">Customer</th>
                    <th class="py-3 px-4">Issue Date</th>
                    <th class="py-3 px-4">Due Date</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Amount</th>
                </tr>
                </thead>
                <tbody>
                @forelse($invoices as $invoice)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $invoice->invoice_number }}</td>
                        <td class="py-3 px-4">{{ $invoice->customer->name ?? '—' }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                        <td class="py-3 px-4">
                            @if($invoice->status === 'paid')
                                <span class="bg-green-100 text-green-700 px-2 py-1 text-xs rounded">Paid</span>
                            @elseif($invoice->status === 'overdue')
                                <span class="bg-red-100 text-red-700 px-2 py-1 text-xs rounded">Overdue</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 text-xs rounded">Unpaid</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-semibold">${{ number_format($invoice->total_amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">No invoices found for selected filters.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        </div>

    </main>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('invoiceChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels ?? []) !!},
                datasets: [{
                    label: 'Total Amount ($)',
                    data: {!! json_encode($chartData ?? []) !!},
                    backgroundColor: '#2563eb'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection
