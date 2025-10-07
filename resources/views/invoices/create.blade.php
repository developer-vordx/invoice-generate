<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice - ReconX</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-56 bg-slate-800 text-white flex flex-col">
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exchange-alt text-white"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold">ReconX</h1>
                    <p class="text-xs text-gray-400">Invoice Reconciliation</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 px-3 py-6 space-y-1">
            <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg transition">
                <i class="fas fa-th-large w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="/invoices" class="flex items-center space-x-3 px-4 py-3 bg-blue-600 rounded-lg text-white">
                <i class="fas fa-file-invoice w-5"></i>
                <span class="font-medium">Invoices</span>
            </a>
            <a href="/customers" class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg transition">
                <i class="fas fa-users w-5"></i>
                <span>Customers</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="/invoices" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-xl font-bold text-gray-800">Create New Invoice</h2>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            <div class="max-w-4xl mx-auto">
                <form id="invoiceForm" class="space-y-6">

                    <!-- Customer Section -->
                    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Customer Details</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select or Add Customer *</label>
                                <div class="flex space-x-2">
                                    <input type="text" id="searchCustomer" placeholder="Search or create..."
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                                    <button type="button" id="openCustomerModal"
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Customer Email *</label>
                                <input type="email" id="customerEmail" placeholder="customer@example.com"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                                <input type="text" id="street" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" id="city" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State / Province</label>
                                <input type="text" id="state" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Zip / Postal Code *</label>
                                <input type="text" id="zip" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" required>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <input type="text" id="country" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600" required>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Invoice Details</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Number *</label>
                                <input type="text" id="invoiceNumber" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Issue Date *</label>
                                <input type="date" id="issueDate" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Due Date *</label>
                                <input type="date" id="dueDate" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Currency *</label>
                                <select id="currency" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Line Items -->
                    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Line Items</h3>
                            <button type="button" id="addLineItem"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>Add Item
                            </button>
                        </div>

                        <div id="lineItemsContainer" class="space-y-4"></div>

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
                    <div class="flex justify-end space-x-4">
                        <a href="/invoices" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50">Cancel</a>
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

<!-- Customer Modal -->
<div id="customerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-8">
        <h3 class="text-lg font-semibold mb-6">Add New Customer</h3>
        <form id="customerForm" class="space-y-4">
            <input type="text" id="newCustomerName" placeholder="Customer Name" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
            <input type="email" id="newCustomerEmail" placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
            <input type="text" id="newCustomerStreet" placeholder="Street Address" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" id="newCustomerCity" placeholder="City" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                <input type="text" id="newCustomerCountry" placeholder="Country" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" id="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Save Customer</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lineItemsContainer = document.getElementById('lineItemsContainer');
        const addLineItemBtn = document.getElementById('addLineItem');
        const totalAmount = document.getElementById('totalAmount');
        const customerModal = document.getElementById('customerModal');
        const openModalBtn = document.getElementById('openCustomerModal');
        const closeModalBtn = document.getElementById('closeModal');
        const customerForm = document.getElementById('customerForm');
        const searchCustomer = document.getElementById('searchCustomer');

        // Add new line item dynamically
        function addLineItem() {
            const itemRow = document.createElement('div');
            itemRow.className = 'grid grid-cols-12 gap-4 bg-gray-50 p-4 rounded-lg';
            itemRow.innerHTML = `
            <div class="col-span-5">
                <input type="text" placeholder="Description" class="line-description w-full px-4 py-3 border border-gray-300 rounded-lg" required>
            </div>
            <div class="col-span-2">
                <input type="number" placeholder="Qty" class="line-quantity w-full px-4 py-3 border border-gray-300 rounded-lg" value="1" min="1" required>
            </div>
            <div class="col-span-2">
                <input type="number" placeholder="Price" class="line-price w-full px-4 py-3 border border-gray-300 rounded-lg" step="0.01" required>
            </div>
            <div class="col-span-2">
                <input type="text" placeholder="$0.00" class="line-total w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg" readonly>
            </div>
            <div class="col-span-1 flex items-center justify-center">
                <button type="button" class="remove-line text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </div>`;
            lineItemsContainer.appendChild(itemRow);

            const qty = itemRow.querySelector('.line-quantity');
            const price = itemRow.querySelector('.line-price');
            const total = itemRow.querySelector('.line-total');

            function updateRowTotal() {
                const q = parseFloat(qty.value) || 0;
                const p = parseFloat(price.value) || 0;
                total.value = `$${(q * p).toFixed(2)}`;
                updateTotal();
            }

            qty.addEventListener('input', updateRowTotal);
            price.addEventListener('input', updateRowTotal);

            itemRow.querySelector('.remove-line').addEventListener('click', () => {
                itemRow.remove();
                updateTotal();
            });
        }

        function updateTotal() {
            let sum = 0;
            document.querySelectorAll('.line-total').forEach(el => {
                sum += parseFloat(el.value.replace('$', '')) || 0;
            });
            totalAmount.textContent = `$${sum.toFixed(2)}`;
        }

        addLineItemBtn.addEventListener('click', addLineItem);

        // Initialize with one line
        addLineItem();

        // Handle customer modal
        openModalBtn.addEventListener('click', () => customerModal.classList.remove('hidden'));
        closeModalBtn.addEventListener('click', () => customerModal.classList.add('hidden'));

        customerForm.addEventListener('submit', e => {
            e.preventDefault();
            const name = document.getElementById('newCustomerName').value;
            const email = document.getElementById('newCustomerEmail').value;
            searchCustomer.value = name;
            document.getElementById('customerEmail').value = email;
            customerModal.classList.add('hidden');
            customerForm.reset();
            alert('Customer added successfully!');
        });
    });
</script>
</body>
</html>
