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

            <!-- Filters -->
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
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                        <td class="px-6 py-4 font-semibold text-blue-600">INV-2024-001</td>
                        <td class="px-6 py-4 text-gray-800">Acme Corp Ltd</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">USD 15,000.00</td>
                        <td class="px-6 py-4 text-gray-600">Jan 15, 2024</td>
                        <td class="px-6 py-4 text-gray-600">Feb 14, 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-green-600 bg-green-50 rounded-full">Paid</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-eye"></i></button>
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-edit"></i></button>
                            <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                        <td class="px-6 py-4 font-semibold text-blue-600">INV-2024-002</td>
                        <td class="px-6 py-4 text-gray-800">Global Tech Solutions</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">EUR 25,000.00</td>
                        <td class="px-6 py-4 text-gray-600">Jan 20, 2024</td>
                        <td class="px-6 py-4 text-gray-600">Feb 19, 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-50 rounded-full">Sent</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-eye"></i></button>
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-edit"></i></button>
                            <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                        <td class="px-6 py-4 font-semibold text-blue-600">INV-2024-003</td>
                        <td class="px-6 py-4 text-gray-800">Manufacturing Co</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">GBP 8,500.00</td>
                        <td class="px-6 py-4 text-gray-600">Jan 10, 2024</td>
                        <td class="px-6 py-4 text-gray-600">Feb 9, 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-red-600 bg-red-50 rounded-full">Overdue</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('invoices.show', 1) }}" class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-eye"></i></a>
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-edit"></i></button>
                            <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-download"></i></button>
                        </td>

                    </tr>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                        <td class="px-6 py-4 font-semibold text-blue-600">INV-2024-004</td>
                        <td class="px-6 py-4 text-gray-800">TechStart Inc</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">USD 45,000.00</td>
                        <td class="px-6 py-4 text-gray-600">Jan 25, 2024</td>
                        <td class="px-6 py-4 text-gray-600">Feb 24, 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">Draft</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-eye"></i></button>
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-edit"></i></button>
                            <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded"></td>
                        <td class="px-6 py-4 font-semibold text-blue-600">INV-2024-005</td>
                        <td class="px-6 py-4 text-gray-800">Digital Solutions Ltd</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">USD 32,500.00</td>
                        <td class="px-6 py-4 text-gray-600">Feb 1, 2024</td>
                        <td class="px-6 py-4 text-gray-600">Mar 2, 2024</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold text-green-600 bg-green-50 rounded-full">Paid</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-eye"></i></button>
                            <button class="text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-edit"></i></button>
                            <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Showing <span class="font-semibold">1-5</span> of <span class="font-semibold">156</span> invoices
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                            Previous
                        </button>
                        <button class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">1</button>
                        <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">2</button>
                        <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">3</button>
                        <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
@endsection
