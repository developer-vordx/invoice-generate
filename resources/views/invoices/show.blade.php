
@extends('layouts.auth.app')

@section('title', 'View Invoice - ReconX')
@php($hideNavbar = true)

@section('content')


    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-600 hover:text-gray-800"><i class="fas fa-arrow-left"></i></a>
                    <h2 class="text-xl font-bold text-gray-800">Invoice Details</h2>
                </div>
                <div class="flex space-x-3">
                    <button id="editInvoiceBtn" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </button>
                    <button id="sendEmailBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-envelope mr-2"></i>Send Email
                    </button>
                    <button onclick="window.print()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        <i class="fas fa-download mr-2"></i>Download PDF
                    </button>
                    <button id="voidBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        <i class="fas fa-ban mr-2"></i>Void
                    </button>
                </div>
            </div>
        </header>

        <!-- Invoice Display -->
        <main class="flex-1 overflow-y-auto p-8">
            <div class="max-w-4xl mx-auto bg-white p-12 rounded-xl shadow-sm border border-gray-100" id="invoiceContent">
                <div class="flex justify-between mb-12">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">INVOICE</h1>
                        <p class="text-lg text-gray-600" id="invoiceNumber"></p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-bold text-gray-800" id="companyName"></h2>
                        <p class="text-gray-600" id="companyAddress"></p>
                        <p class="text-gray-600" id="companyContact"></p>
                    </div>
                </div>

                <!-- Billing Info -->
                <div class="grid grid-cols-2 gap-8 mb-12">
                    <div>
                        <p class="text-sm text-gray-500 mb-2">BILL TO:</p>
                        <div id="clientInfo"></div>
                    </div>
                    <div class="text-right">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <span class="text-gray-500">Issue Date:</span><span id="issueDate" class="font-semibold"></span>
                            <span class="text-gray-500">Due Date:</span><span id="dueDate" class="font-semibold"></span>
                            <span class="text-gray-500">Status:</span><span id="status"></span>
                        </div>
                    </div>
                </div>

                <!-- Line Items -->
                <table class="w-full mb-8">
                    <thead class="border-b-2 border-gray-300">
                    <tr class="text-left">
                        <th class="pb-4 text-sm font-semibold text-gray-600">DESCRIPTION</th>
                        <th class="pb-4 text-sm font-semibold text-gray-600 text-center">QTY</th>
                        <th class="pb-4 text-sm font-semibold text-gray-600 text-right">UNIT PRICE</th>
                        <th class="pb-4 text-sm font-semibold text-gray-600 text-right">AMOUNT</th>
                    </tr>
                    </thead>
                    <tbody id="lineItems" class="divide-y divide-gray-200"></tbody>
                </table>

                <!-- Totals -->
                <div class="flex justify-end mb-12">
                    <div class="w-64">
                        <div class="flex justify-between py-2 border-t border-gray-200">
                            <span class="font-semibold">Subtotal:</span><span id="subtotal"></span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-200">
                            <span class="font-semibold">Tax (10%):</span><span id="taxAmount"></span>
                        </div>
                        <div class="flex justify-between py-3 border-t-2 border-gray-800 text-xl font-bold">
                            <span>Total:</span><span id="total"></span>
                        </div>
                    </div>
                </div>

                <!-- Notes & Terms -->
                <div class="mt-8 border-t border-gray-200 pt-8 text-sm">
                    <div class="mb-6">
                        <h3 class="font-bold text-gray-800 mb-2">Notes</h3>
                        <p class="text-gray-600" id="invoiceNotes"></p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2">Terms & Conditions</h3>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2" id="invoiceTerms"></ul>
                    </div>
                </div>
            </div>
        </main>
    </div>


<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-8 max-w-3xl w-full mx-4">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Invoice</h3>
        <form id="editForm">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client Name</label>
                    <input type="text" id="editClientName" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client Email</label>
                    <input type="email" id="editClientEmail" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Client Address</label>
                <input type="text" id="editClientAddress" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
            </div>
            <h4 class="text-lg font-semibold mb-4">Line Items</h4>
            <div id="editLineItems" class="space-y-3"></div>
            <div class="flex justify-end mt-6 space-x-3">
                <button type="button" id="closeEditModal" class="px-6 py-3 border border-gray-300 rounded-lg">Cancel</button>
                <button type="submit" class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    const invoice = {
        invoice_number: "INV-2025-001",
        issue_date: "2025-09-01",
        due_date: "2025-09-15",
        status: "sent", // can be "sent", "paid", "void"
        tax_rate: 0.1,
        currency: "USD",
        client: { name: "Acme Corp", email: "billing@acme.com", address: "123 Business Rd" },
        line_items: [
            { description: "Web Design", quantity: 1, unit_price: 800 },
            { description: "Hosting", quantity: 1, unit_price: 200 },
        ],
        company: { name: "ReconX Inc.", address: "456 Corporate Blvd", contact: "info@reconx.com" },
        notes: "Payment via bank transfer only.",
        terms: ["Payment within 15 days", "5% late fee", "Non-refundable after 30 days"],
    };

    function loadInvoice() {
        document.getElementById("invoiceNumber").textContent = invoice.invoice_number;
        document.getElementById("issueDate").textContent = new Date(invoice.issue_date).toLocaleDateString();
        document.getElementById("dueDate").textContent = new Date(invoice.due_date).toLocaleDateString();

        const statusColors = {
            sent: "bg-blue-100 text-blue-600",
            paid: "bg-green-100 text-green-600",
            void: "bg-red-100 text-red-600",
        };
        document.getElementById("status").innerHTML = `<span class="px-3 py-1 text-xs font-semibold rounded-full ${statusColors[invoice.status]}">${invoice.status.toUpperCase()}</span>`;

        document.getElementById("companyName").textContent = invoice.company.name;
        document.getElementById("companyAddress").textContent = invoice.company.address;
        document.getElementById("companyContact").textContent = invoice.company.contact;
        document.getElementById("clientInfo").innerHTML = `<p>${invoice.client.name}</p><p>${invoice.client.email}</p><p>${invoice.client.address}</p>`;

        let subtotal = 0;
        document.getElementById("lineItems").innerHTML = invoice.line_items.map(i => {
            const lineTotal = i.quantity * i.unit_price;
            subtotal += lineTotal;
            return `<tr><td>${i.description}</td><td class="text-center">${i.quantity}</td><td class="text-right">${i.unit_price}</td><td class="text-right">${lineTotal}</td></tr>`;
        }).join("");
        const tax = subtotal * invoice.tax_rate;
        const total = subtotal + tax;
        document.getElementById("subtotal").textContent = `${invoice.currency} ${subtotal.toFixed(2)}`;
        document.getElementById("taxAmount").textContent = `${invoice.currency} ${tax.toFixed(2)}`;
        document.getElementById("total").textContent = `${invoice.currency} ${total.toFixed(2)}`;
        document.getElementById("invoiceNotes").textContent = invoice.notes;
        document.getElementById("invoiceTerms").innerHTML = invoice.terms.map(t => `<li>${t}</li>`).join("");

        // Hide edit/void buttons if voided or paid
        if (invoice.status === "paid" || invoice.status === "void") {
            document.getElementById("editInvoiceBtn").classList.add("hidden");
        } else {
            document.getElementById("editInvoiceBtn").classList.remove("hidden");
        }
        if (invoice.status !== "paid" && invoice.status !== "void") {
            document.getElementById("voidBtn").classList.remove("hidden");
        } else {
            document.getElementById("voidBtn").classList.add("hidden");
        }
    }

    // Edit Modal Logic
    document.getElementById("editInvoiceBtn").addEventListener("click", () => {
        document.getElementById("editModal").classList.remove("hidden");
        document.getElementById("editClientName").value = invoice.client.name;
        document.getElementById("editClientEmail").value = invoice.client.email;
        document.getElementById("editClientAddress").value = invoice.client.address;
        document.getElementById("editLineItems").innerHTML = invoice.line_items.map((item, idx) => `
        <div class="grid grid-cols-3 gap-3">
          <input value="${item.description}" id="desc${idx}" class="px-3 py-2 border rounded-lg" />
          <input type="number" value="${item.quantity}" id="qty${idx}" class="px-3 py-2 border rounded-lg" />
          <input type="number" value="${item.unit_price}" id="price${idx}" class="px-3 py-2 border rounded-lg" />
        </div>
      `).join("");
    });

    document.getElementById("closeEditModal").addEventListener("click", () => {
        document.getElementById("editModal").classList.add("hidden");
    });

    document.getElementById("editForm").addEventListener("submit", e => {
        e.preventDefault();
        invoice.client.name = document.getElementById("editClientName").value;
        invoice.client.email = document.getElementById("editClientEmail").value;
        invoice.client.address = document.getElementById("editClientAddress").value;
        invoice.line_items = invoice.line_items.map((item, idx) => ({
            description: document.getElementById(`desc${idx}`).value,
            quantity: parseInt(document.getElementById(`qty${idx}`).value),
            unit_price: parseFloat(document.getElementById(`price${idx}`).value),
        }));
        loadInvoice();
        document.getElementById("editModal").classList.add("hidden");
        alert("Invoice updated successfully!");
    });

    // Void Button Logic
    document.getElementById("voidBtn").addEventListener("click", () => {
        if (confirm("Are you sure you want to void this invoice? This action cannot be undone.")) {
            invoice.status = "void";
            loadInvoice();
            alert("Invoice has been voided.");
        }
    });

    loadInvoice();
</script>
@endsection
