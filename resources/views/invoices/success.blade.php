@extends('layouts.guest.app')

@section('content')
    <div class="max-w-5xl mx-auto mt-10 bg-white rounded-2xl shadow p-6">
        {{-- Success Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-green-600 mb-2">✅ Payment Successful</h1>
            <p class="text-gray-700">Thank you for paying Invoice <strong>#{{ $invoice->invoice_number }}</strong>.</p>
            <p class="text-gray-700">Amount Paid: <strong>${{ number_format($invoice->amount, 2) }}</strong></p>
            <a href="{{ route('invoices.download', $invoice->id) }}"
               class="mt-4 inline-block bg-indigo-600 text-white font-semibold py-2 px-6 rounded-xl hover:bg-indigo-700 transition">
                Download Invoice PDF
            </a>
        </div>

        {{-- Invoice Details --}}
        <div class="space-y-6">
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-lg mb-1">Billed To:</h2>
                    <p>{{ $invoice->customer->name ?? 'N/A' }}</p>
                    <p>{{ $invoice->customer->email ?? 'N/A' }}</p>
                    <p>{{ $invoice->customer->address ?? 'N/A' }}</p>
                </div>
                <div class="text-right">
                    <p><strong>Invoice #: </strong>{{ $invoice->invoice_number }}</p>
                    <p><strong>Issue Date:</strong> {{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</p>
                    <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                    <p><strong>Status:</strong>
                        <span class="px-2 py-1 rounded font-semibold text-white {{ $invoice->status == 'paid' ? 'bg-green-600' : 'bg-gray-400' }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                    </p>
                </div>
            </div>

            {{-- Line Items --}}
            <div>
                <h2 class="font-semibold text-lg mb-2">Invoice Items</h2>
                <table class="w-full border-collapse border">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Description</th>
                        <th class="border p-2 text-center">Qty</th>
                        <th class="border p-2 text-right">Unit Price</th>
                        <th class="border p-2 text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($invoice->items as $item)
                        <tr class="border-t">
                            <td class="p-2">{{ $item->activity }}</td>
                            <td class="p-2 text-center">{{ $item->quantity }}</td>
                            <td class="p-2 text-right">${{ number_format($item->amount, 2) }}</td>
                            <td class="p-2 text-right">${{ number_format($item->quantity * $item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                    @if ($invoice->rush_enabled)
                        <tr class="border-t bg-yellow-50">
                            <td class="p-2 font-medium">Rush Add-On ({{ ucfirst($invoice->rush_delivery_type) }})</td>
                            <td class="p-2 text-center">1</td>
                            <td class="p-2 text-right">${{ number_format($invoice->rush_fee, 2) }}</td>
                            <td class="p-2 text-right">${{ number_format($invoice->rush_fee, 2) }}</td>
                        </tr>
                    @endif
                    </tbody>
                    @php
                        $subtotal = $invoice->items->sum(fn($item) => $item->quantity * $item->amount);
                        $rushFee = ($invoice->rush_enabled) ? $invoice->rush_fee : 0;
                        $total = $subtotal + $rushFee;
                    @endphp
                    <tfoot>
                    <tr class="bg-gray-100 font-semibold">
                        <td colspan="3" class="p-2 text-right">Subtotal:</td>
                        <td class="p-2 text-right">${{ number_format($subtotal + $rushFee, 2) }}</td>
                    </tr>
                    <tr class="bg-gray-100 font-semibold">
                        <td colspan="3" class="p-2 text-right">Total Paid:</td>
                        <td class="p-2 text-right">${{ number_format($total, 2) }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Notes --}}
            @if(!empty($invoice->note))
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-lg mb-1">Notes</h3>
                    <p class="text-gray-700">{{ $invoice->note }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
