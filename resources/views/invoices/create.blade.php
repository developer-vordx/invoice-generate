@extends('layouts.auth.app')

@section('title', 'Create Invoice - ReconX')
@php($hideNavbar = true)

@section('content')
    <div class="min-h-screen bg-gray-50 flex flex-col">
        {{-- Header --}}
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shadow-sm sticky top-0 z-20">
            <div class="flex items-center space-x-4">
                <a href="{{ route('invoices.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-xl font-bold text-gray-800">Create New Invoice</h2>
            </div>
        </header>

        {{-- Main --}}
        <main class="p-8">
            <div class="max-w-5xl mx-auto space-y-8">
                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form id="invoiceForm" action="{{ route('invoices.store') }}" method="POST" class="space-y-8">
                    @csrf

                    {{-- CUSTOMER DETAILS --}}
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Customer Details</h3>
                            <a href="{{ route('customers.create') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                <i class="fas fa-user-plus mr-1"></i> Add New Customer
                            </a>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Customer</label>
                                <select id="customerSelect" name="customer_id" class="w-full"></select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text"
                                   id="customer_name"
                                   name="name"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                                   required>
                        </div>


                        <div class="grid grid-cols-2 gap-6">


                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                                <input type="text" id="customer_company_name" name="company_name"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" id="customer_email" name="email"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                                <input type="text" id="customer_address" name="address"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" id="customer_city" name="city"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" required>
                            </div>
                        </div>
                    </div>

                    {{-- INVOICE DETAILS --}}
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Invoice Details</h3>

                        {{-- Changed from 3 columns → 2 columns --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Invoice Number *</label>
                                <input type="text"
                                       name="invoice_number"
                                       value="{{ old('invoice_number') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Issue Date *</label>
                                <input type="date"
                                       name="issue_date"
                                       value="{{ old('issue_date', now()->format('Y-m-d')) }}"
                                       min="{{ now()->format('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                                       required>
                            </div>
                        </div>
                    </div>

                    {{-- LINE ITEMS --}}
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Line Items</h3>
                            <button type="button" id="addLineItem"
                                    class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>Add Line Item
                            </button>
                        </div>

                        <div id="lineItemsContainer" class="space-y-4"></div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-end">
                                <div class="w-64 text-lg font-semibold text-gray-800 flex justify-between">
                                    <span>Total:</span>
                                    <span id="totalAmount">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('invoices.index') }}"
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                            Create Invoice
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    {{-- JS + Select2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 46px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 6px 12px !important;
            display: flex;
            align-items: center;
        }
        .select2-selection__arrow {
            top: 8px !important;
            right: 8px !important;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-container {
            width: 100% !important;
        }

        .select2-results__options {
            max-height: 350px !important;
            width: 100% !important;
        }

    </style>

    <script>
        $(document).ready(function () {
            // ✅ Customer Select2
            $('#customerSelect').select2({
                placeholder: 'Search customer...',
                ajax: {
                    url: '{{ route("customers.fetch") }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (response) {
                        if (response.success) {
                            return {
                                results: response.data.map(c => ({
                                    id: c.id,
                                    text: c.text,
                                    name: c.name,
                                    email: c.email,
                                    address: c.address,
                                    city: c.city,
                                    company_name: c.company_name,
                                    country: c.country,
                                }))
                            };
                        }
                        return { results: [] };
                    },
                    cache: true
                }
            });

            $('#customerSelect').on('select2:select', function (e) {
                const data = e.params.data;
                $('#customer_name').val(data.name);
                $('#customer_company_name').val(data.company_name);
                $('#customer_email').val(data.email);
                $('#customer_address').val(data.address);
                $('#customer_city').val(data.city);
            });

            // ✅ Line Items Logic
            const container = document.getElementById('lineItemsContainer');
            const addBtn = document.getElementById('addLineItem');
            const totalDisplay = document.getElementById('totalAmount');

            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.line-total').forEach(el => {
                    total += parseFloat(el.dataset.value || 0);
                });
                totalDisplay.textContent = `$${total.toFixed(2)}`;
            }

            function addLineItem() {
                const index = container.children.length;
                const row = document.createElement('div');
                row.className =
                    'grid grid-cols-12 gap-4 items-center bg-gray-50 p-4 rounded-lg border border-gray-200';
                row.innerHTML = `
            <div class="col-span-8">
                <select class="product-select w-full border border-gray-300 rounded-lg"></select>
            </div>
            <div class="col-span-3">
                <input type="text" class="line-total w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-right font-semibold text-gray-800" value="$0.00" readonly data-value="0">
            </div>
            <div class="col-span-1 text-center">
                <button type="button" class="remove-line text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <!-- Hidden fields -->
            <input type="hidden" name="line_items[${index}][quantity]" value="1" class="line-quantity">
            <input type="hidden" name="line_items[${index}][unit_price]" value="0" class="line-price">
            <input type="hidden" name="line_items[${index}][description]" class="line-description">
        `;
                container.appendChild(row);

                const qty = row.querySelector('.line-quantity');
                const price = row.querySelector('.line-price');
                const total = row.querySelector('.line-total');
                const productSelect = row.querySelector('.product-select');
                const desc = row.querySelector('.line-description');

                // ✅ Initialize wider product dropdown
                $(productSelect).select2({
                    placeholder: 'Search product...',
                    width: '100%',
                    dropdownAutoWidth: true,
                    dropdownParent: $(productSelect).parent(),
                    ajax: {
                        url: '{{ route("products.fetch") }}',
                        dataType: 'json',
                        delay: 250,
                        processResults: function (response) {
                            if (response.success) {
                                const items = response.data.map(p => ({
                                    id: p.id,
                                    text: p.label,
                                    price: p.price,
                                    name: p.name
                                }));
                                items.push({ id: 'other', text: 'Other (Custom Product)', price: 0, name: '' });
                                return { results: items };
                            }
                            return { results: [] };
                        },
                        cache: true
                    }
                });

                // ✅ Handle selection
                $(productSelect).on('select2:select', function (e) {
                    const data = e.params.data;
                    if (data.id === 'other') {
                        desc.value = '';
                        price.value = '0';
                        desc.removeAttribute('readonly');
                    } else {
                        desc.value = data.name;
                        desc.setAttribute('readonly', true);
                        price.value = data.price;
                    }

                    const lineTotal = parseFloat(qty.value) * parseFloat(price.value);
                    total.value = `$${lineTotal.toFixed(2)}`;
                    total.dataset.value = lineTotal;
                    updateTotal();
                });

                // ✅ Remove line item
                row.querySelector('.remove-line').addEventListener('click', () => {
                    row.remove();
                    updateTotal();
                });

                updateTotal();
            }

            addBtn.addEventListener('click', addLineItem);
        });
    </script>

@endsection
