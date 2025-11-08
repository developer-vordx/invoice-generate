@extends('layouts.guest.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 bg-white rounded-2xl shadow p-6">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">
            Review & Accept Invoice #{{ $invoice->invoice_number }}
        </h1>

        <div class="space-y-4">
            {{-- Customer Info --}}
            <div>
                <h2 class="font-semibold text-lg">Invoice Details</h2>
                <p><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
                <p><strong>Email:</strong> {{ $invoice->customer->email }}</p>
                <p><strong>Project Address:</strong> {{ $invoice->project_address }}</p>
            </div>

            {{-- Items --}}
            <div>
                <h2 class="font-semibold text-lg">Line Items</h2>
                <table class="w-full border mt-2">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2 text-right">Qty</th>
                        <th class="p-2 text-right">Unit Price</th>
                        <th class="p-2 text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($invoice->items as $item)
                        <tr class="border-t">
                            <td class="p-2">{{ $item->activity }}</td>
                            <td class="p-2 text-right">{{ $item->quantity }}</td>
                            <td class="p-2 text-right">${{ number_format($item->amount, 2) }}</td>
                            <td class="p-2 text-right">${{ number_format($item->quantity * $item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="border-t font-semibold bg-gray-100">
                    <tr>
                        <td colspan="3" class="p-2 text-right">Subtotal</td>
                        <td class="p-2 text-right" id="subtotal-td">
                            ${{ number_format($invoice->items->sum(fn($item) => $item->quantity * $item->amount), 2) }}
                        </td>
                    </tr>
                    @if ($invoice->rush_fee)
                        <tr id="rush-row" class="border-t bg-yellow-50 hidden">
                            <td class="p-2 font-medium">
                                Rush Add-On ({{ ucfirst($invoice->rush_delivery_type) }} Delivery)
                            </td>
                            <td class="p-2 text-right">1</td>
                            <td class="p-2 text-right">${{ number_format($invoice->rush_fee, 2) }}</td>
                            <td class="p-2 text-right" id="rush-total">
                                ${{ number_format($invoice->rush_fee, 2) }}
                            </td>
                        </tr>
                    @endif
                    <tr class="border-t font-semibold bg-gray-100">
                        <td colspan="3" class="p-2 text-right">Total</td>
                        <td class="p-2 text-right" id="total-td">
                            ${{ number_format($invoice->items->sum(fn($item) => $item->quantity * $item->amount), 2) }}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Rush Toggle --}}
        @if ($invoice->rush_fee)
            <div class="mt-6 flex items-center justify-between bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <label for="rush_enabled" class="text-gray-800 font-medium">
                    <span class="block text-lg">Enable Rush Delivery</span>
                    <span class="text-sm text-gray-600">
                    Get priority {{ $invoice->rush_delivery_type }} delivery within 24 hours for an extra
                    ${{ number_format($invoice->rush_fee, 2) }}.
                </span>
                </label>
                <input type="checkbox" id="rush_enabled" name="rush_enabled"
                       class="w-6 h-6 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
            </div>
        @endif

        {{-- Payment Form --}}
        <form id="payment-form" action="{{ route('invoices.pay', $invoice->id) }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="rush_enabled_value" id="rush_enabled_value" value="0">

            <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-xl hover:bg-indigo-700 transition">
                Proceed to Secure Payment
            </button>
        </form>
    </div>

    {{-- JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rushCheckbox = document.getElementById('rush_enabled');
            const rushRow = document.getElementById('rush-row');
            const subtotalEl = document.getElementById('subtotal-td');
            const totalEl = document.getElementById('total-td');
            const rushTotal = parseFloat(@json($invoice->rush_fee ?? 0));
            const subtotal = parseFloat(@json($invoice->items->sum(fn($i) => $i->quantity * $i->amount)));
            const rushValueInput = document.getElementById('rush_enabled_value');

            function updateTotal() {
                if (rushCheckbox && rushCheckbox.checked) {
                    if (rushRow) rushRow.classList.remove('hidden');
                    totalEl.textContent = '$' + (subtotal + rushTotal).toFixed(2);
                    rushValueInput.value = '1';
                } else {
                    if (rushRow) rushRow.classList.add('hidden');
                    totalEl.textContent = '$' + subtotal.toFixed(2);
                    rushValueInput.value = '0';
                }
            }

            if (rushCheckbox) {
                rushCheckbox.addEventListener('change', updateTotal);
            }
            updateTotal();
        });
    </script>
@endsection
