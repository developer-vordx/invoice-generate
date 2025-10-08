@extends('layouts.auth.app')

@section('title', 'Create Invoice - ReconX')
@php($hideNavbar = true)

@section('content')
    <div class="flex h-screen overflow-hidden">

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('invoices.index') }}" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h2 class="text-xl font-bold text-gray-800">Create New Invoice</h2>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                <div class="max-w-4xl mx-auto">

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="invoiceForm" action="{{ route('invoices.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Customer Section -->
                        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Customer Details</h3>
                            <div class="grid grid-cols-2 gap-6">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                                    <input type="text" name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Customer Name"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('name') border-red-500 @enderror" required>
                                    @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email"
                                           value="{{ old('email') }}"
                                           placeholder="customer@example.com"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('email') border-red-500 @enderror" required>
                                    @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('address') border-red-500 @enderror" required>
                                    @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                    <input type="text" name="city" value="{{ old('city') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('city') border-red-500 @enderror" required>
                                    @error('city')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">State / Province</label>
                                    <input type="text" name="state" value="{{ old('state') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('postal_code') border-red-500 @enderror" required>
                                    @error('postal_code')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                    <input type="text" name="country" value="{{ old('country') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('country') border-red-500 @enderror" required>
                                    @error('country')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Details -->
                        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Invoice Details</h3>
                            <div class="grid grid-cols-2 gap-6">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Number *</label>
                                    <input type="text" name="invoice_number"
                                           value="{{ old('invoice_number') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('invoice_number') border-red-500 @enderror" required>
                                    @error('invoice_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Issue Date *</label>
                                    <input type="date" name="issue_date"
                                           value="{{ old('issue_date') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('issue_date') border-red-500 @enderror" required>
                                    @error('issue_date')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Due Date *</label>
                                    <input type="date" name="due_date"
                                           value="{{ old('due_date') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('due_date') border-red-500 @enderror" required>
                                    @error('due_date')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency *</label>
                                    <select name="currency" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('currency') border-red-500 @enderror" required>
                                        <option value="USD" {{ old('currency')=='USD' ? 'selected':'' }}>USD</option>
                                        <option value="EUR" {{ old('currency')=='EUR' ? 'selected':'' }}>EUR</option>
                                        <option value="GBP" {{ old('currency')=='GBP' ? 'selected':'' }}>GBP</option>
                                    </select>
                                    @error('currency')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Line Items -->
                        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mt-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">Line Items</h3>
                                <button type="button" id="addLineItem"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>Add Item
                                </button>
                            </div>

                            <div id="lineItemsContainer" class="space-y-4">
                                {{-- Old line items --}}
                                @if(old('line_items'))
                                    @foreach(old('line_items') as $index => $item)
                                        <div class="grid grid-cols-12 gap-4 bg-gray-50 p-4 rounded-lg">
                                            <div class="col-span-5">
                                                <input type="text" name="line_items[{{ $index }}][description]"
                                                       value="{{ $item['description'] }}" placeholder="Description"
                                                       class="line-description w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                                            </div>
                                            <div class="col-span-2">
                                                <input type="number" name="line_items[{{ $index }}][quantity]"
                                                       value="{{ $item['quantity'] }}" placeholder="Qty"
                                                       class="line-quantity w-full px-4 py-3 border border-gray-300 rounded-lg" min="1" required>
                                            </div>
                                            <div class="col-span-2">
                                                <input type="number" name="line_items[{{ $index }}][unit_price]"
                                                       value="{{ $item['unit_price'] }}" placeholder="Price"
                                                       class="line-price w-full px-4 py-3 border border-gray-300 rounded-lg" step="0.01" required>
                                            </div>
                                            <div class="col-span-2">
                                                <input type="text" value="${{ number_format($item['quantity']*$item['unit_price'],2) }}" class="line-total w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                                            </div>
                                            <div class="col-span-1 flex items-center justify-center">
                                                <button type="button" class="remove-line text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex justify-end">
                                    <div class="w-64">
                                        <div class="flex justify-between text-lg font-semibold text-gray-800">
                                            <span>Total:</span>
                                            <span id="totalAmount">$0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('invoices.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50">Cancel</a>
                            <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                                Create Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    {{-- JS for dynamic line items --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lineItemsContainer = document.getElementById('lineItemsContainer');
            const addLineItemBtn = document.getElementById('addLineItem');
            const totalAmount = document.getElementById('totalAmount');

            function updateTotal() {
                let sum = 0;
                document.querySelectorAll('.line-total').forEach(el => {
                    sum += parseFloat(el.value.replace('$','')) || 0;
                });
                totalAmount.textContent = `$${sum.toFixed(2)}`;
            }

            function addLineItem(desc='', qty=1, price=0) {
                const index = lineItemsContainer.children.length;
                const row = document.createElement('div');
                row.className = 'grid grid-cols-12 gap-4 bg-gray-50 p-4 rounded-lg';
                row.innerHTML = `
            <div class="col-span-5">
                <input type="text" name="line_items[${index}][description]" value="${desc}" placeholder="Description"
                       class="line-description w-full px-4 py-3 border border-gray-300 rounded-lg" required>
            </div>
            <div class="col-span-2">
                <input type="number" name="line_items[${index}][quantity]" value="${qty}" placeholder="Qty"
                       class="line-quantity w-full px-4 py-3 border border-gray-300 rounded-lg" min="1" required>
            </div>
            <div class="col-span-2">
                <input type="number" name="line_items[${index}][unit_price]" value="${price}" placeholder="Price"
                       class="line-price w-full px-4 py-3 border border-gray-300 rounded-lg" step="0.01" required>
            </div>
            <div class="col-span-2">
                <input type="text" value="$${(qty*price).toFixed(2)}" class="line-total w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg" readonly>
            </div>
            <div class="col-span-1 flex items-center justify-center">
                <button type="button" class="remove-line text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
            </div>
        `;
                lineItemsContainer.appendChild(row);

                const qtyInput = row.querySelector('.line-quantity');
                const priceInput = row.querySelector('.line-price');
                const totalInput = row.querySelector('.line-total');

                function updateRowTotal() {
                    const q = parseFloat(qtyInput.value) || 0;
                    const p = parseFloat(priceInput.value) || 0;
                    totalInput.value = `$${(q*p).toFixed(2)}`;
                    updateTotal();
                }

                qtyInput.addEventListener('input', updateRowTotal);
                priceInput.addEventListener('input', updateRowTotal);

                row.querySelector('.remove-line').addEventListener('click', () => {
                    row.remove();
                    updateTotal();
                });

                updateTotal();
            }

            addLineItemBtn.addEventListener('click', () => addLineItem());
            // Initialize total for old items
            updateTotal();
        });
    </script>
@endsection
