@extends('layouts.auth.app')

@section('title', 'Dashboard - ' . config('app.name', 'ReconX'))

@section('content')

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Invoices</h2>
                <p class="text-gray-600 mt-1">Manage and track all your invoices</p>
            </div>
            <a href="{{ route('invoices.create') }}"
               class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>Create Invoice
            </a>
        </div>

        <!-- Filters (static for now, can be made dynamic later) -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option>All Statuses</option>
                        <option>Paid</option>
                        <option>Sent</option>
                        <option>Draft</option>
                        <option>Overdue</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option>Last 30 days</option>
                        <option>Last 7 days</option>
                        <option>Last 90 days</option>
                        <option>This year</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option>All Clients</option>
                        <option>Acme Corp Ltd</option>
                        <option>Global Tech Solutions</option>
                        <option>Manufacturing Co</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option>Any Amount</option>
                        <option>Under $10,000</option>
                        <option>$10,000 - $50,000</option>
                        <option>Over $50,000</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Invoice #</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Issue Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                        </td>
                        <td class="px-6 py-4 font-semibold">
                            <a href="{{ route('invoices.show', $invoice->id) }}"
                               class="text-blue-600 hover:text-blue-800 hover:underline transition">
                                INV-{{ $invoice->invoice_number }}
                            </a>
                        </td>

                        <td class="px-6 py-4 text-gray-800">{{ $invoice->customer->name }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">USD {{ number_format($invoice->amount, 2) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold
                                @if($invoice->status == 'paid') text-green-600 bg-green-50
                                @elseif($invoice->status == 'overdue') text-red-600 bg-red-50
                                @elseif($invoice->status == 'draft') text-gray-600 bg-gray-100
                                @else text-blue-600 bg-blue-50 @endif
                                rounded-full">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="text-gray-400 hover:text-gray-600 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="text-gray-400 hover:text-gray-600 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('invoices.download', $invoice->id) }}" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500">
                            No invoices found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    @if ($invoices->total() > 0)
                        Showing
                        <span class="font-semibold">{{ $invoices->firstItem() }}</span>
                        to
                        <span class="font-semibold">{{ $invoices->lastItem() }}</span>
                        of
                        <span class="font-semibold">{{ $invoices->total() }}</span>
                        invoices
                    @else
                        No invoices to display.
                    @endif
                </div>

                <div>
                    {{ $invoices->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </main>
@endsection
