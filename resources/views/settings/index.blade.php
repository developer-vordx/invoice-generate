@extends('layouts.auth.app')

@section('title', 'Settings - ' . config('app.name', 'ReconX'))

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- 🔹 Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
            <p class="text-gray-500 mt-1">Manage your organization, integrations, and preferences.</p>
        </div>

        <div class="bg-white shadow-lg rounded-2xl flex overflow-hidden">
            <!-- 🔸 Sidebar Tabs -->
            <div class="w-64 bg-gray-50 border-r border-gray-200">
                <nav class="flex flex-col py-6">
                    <button id="tab-org"
                            class="tab-btn flex items-center px-6 py-3 text-left font-medium text-blue-600 bg-blue-50 border-l-4 border-blue-600">
                        <i class="fas fa-building mr-3 text-blue-600"></i> Organization
                    </button>
                    <button id="tab-int"
                            class="tab-btn flex items-center px-6 py-3 text-left text-gray-600 hover:bg-gray-100 hover:text-blue-600 border-l-4 border-transparent">
                        <i class="fas fa-plug mr-3"></i> Integrations
                    </button>
                    <button id="tab-invoice"
                            class="tab-btn flex items-center px-6 py-3 text-left text-gray-600 hover:bg-gray-100 hover:text-blue-600 border-l-4 border-transparent">
                        <i class="fas fa-file-invoice-dollar mr-3"></i> Invoice Configuration
                    </button>
                    <button id="tab-security"
                            class="tab-btn flex items-center px-6 py-3 text-left text-gray-600 hover:bg-gray-100 hover:text-blue-600 border-l-4 border-transparent">
                        <i class="fas fa-shield-alt mr-3"></i> Security
                    </button>
                    <button id="tab-notifications"
                            class="tab-btn flex items-center px-6 py-3 text-left text-gray-600 hover:bg-gray-100 hover:text-blue-600 border-l-4 border-transparent">
                        <i class="fas fa-bell mr-3"></i> Notifications
                    </button>
                </nav>
            </div>

            <!-- 🔹 Main Content -->
            <div class="flex-1 p-8">
                {{-- 🏢 Organization Settings --}}
                <div id="tab-content-org">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Organization Settings</h2>

                    <form method="POST" action="{{ route('settings.organization.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Company Name</label>
                                <input type="text" name="company_name"
                                       value="{{ old('company_name', $setting->company_name) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Company Email</label>
                                <input type="email" name="contact_email"
                                       value="{{ old('contact_email', $setting->contact_email) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="info@company.com">
                            </div>

                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Country</label>
                                <input type="text" name="country"
                                       value="{{ old('country', $setting->country) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- 🌍 Base Currency Dropdown -->
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Base Currency</label>
                                <select name="base_currency"
                                        class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                    <option value="">-- Select Currency --</option>
                                    <option value="$" {{ old('base_currency', $setting->base_currency) === '$' ? 'selected' : '' }}>🇺🇸 USD — $</option>
                                    <option value="€" {{ old('base_currency', $setting->base_currency) === '€' ? 'selected' : '' }}>🇪🇺 EUR — €</option>
                                    <option value="£" {{ old('base_currency', $setting->base_currency) === '£' ? 'selected' : '' }}>🇬🇧 GBP — £</option>
                                    <option value="₹" {{ old('base_currency', $setting->base_currency) === '₹' ? 'selected' : '' }}>🇮🇳 INR — ₹</option>
                                    <option value="C$" {{ old('base_currency', $setting->base_currency) === 'C$' ? 'selected' : '' }}>🇨🇦 CAD — C$</option>
                                    <option value="A$" {{ old('base_currency', $setting->base_currency) === 'A$' ? 'selected' : '' }}>🇦🇺 AUD — A$</option>
                                    <option value="¥" {{ old('base_currency', $setting->base_currency) === '¥' ? 'selected' : '' }}>🇯🇵 JPY — ¥</option>
                                    <option value="¥" {{ old('base_currency', $setting->base_currency) === '¥' ? 'selected' : '' }}>🇨🇳 CNY — ¥</option>
                                    <option value="Fr" {{ old('base_currency', $setting->base_currency) === 'Fr' ? 'selected' : '' }}>🇨🇭 CHF — Fr</option>
                                    <option value="NZ$" {{ old('base_currency', $setting->base_currency) === 'NZ$' ? 'selected' : '' }}>🇳🇿 NZD — NZ$</option>
                                    <option value="S$" {{ old('base_currency', $setting->base_currency) === 'S$' ? 'selected' : '' }}>🇸🇬 SGD — S$</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Tax Percentage</label>
                                <input type="number" step="0.01" name="tax_percentage"
                                       value="{{ old('tax_percentage', $setting->tax_percentage ?? '') }}"
                                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Company Logo</label>

                                <input type="file" name="logo_path" accept="image/*" id="logo-input"
                                       class="w-full border border-gray-300 rounded-lg p-2.5">

                                <div class="mt-3">

                                    @if(!empty($setting->logo_path) && file_exists(public_path('storage/' . $setting->logo_path)))
                                        <img id="logo-preview"
                                             src="{{ asset('storage/' . $setting->logo_path) }}"
                                             alt="Company Logo"
                                             class="w-24 h-24 object-contain border rounded-lg shadow-sm">
                                    @else
                                        <img id="logo-preview" src="" alt="Preview"
                                             class="hidden w-24 h-24 object-contain border rounded-lg shadow-sm">
                                    @endif
                                </div>
                            </div>


                        </div>

                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Address</label>
                            <textarea name="address" rows="3"
                                      class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $setting->address) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Invoice Notes</label>
                            <textarea name="invoice_notes" rows="3"
                                      class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('invoice_notes', $setting->invoice_notes) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Terms & Conditions</label>
                            <textarea name="invoice_terms" rows="4"
                                      class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('invoice_terms', $setting->invoice_terms) }}</textarea>
                        </div>

                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition-all">
                            Save Changes
                        </button>
                    </form>
                </div>

                {{-- 🔌 Integration Settings --}}
                <div id="tab-content-int" class="hidden">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Integrations</h2>
                    <form method="POST" action="{{ route('settings.integration.update') }}" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Stripe Public Key</label>
                                <input type="text" name="stripe_public_key" value="{{ old('stripe_public_key', $setting->stripe_public_key) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Stripe Secret Key</label>
                                <input type="text" name="stripe_secret_key" value="{{ old('stripe_secret_key', $setting->stripe_secret_key) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Webhook URL</label>
                                <div class="flex items-center">
                                    <input type="text" readonly value="{{ $setting->webhook_url }}"
                                           class="w-full border border-gray-300 rounded-lg p-2.5 bg-gray-100 cursor-not-allowed">
                                    <button type="button"
                                            onclick="copyWebhook('{{ $setting->webhook_url }}')"
                                            class="ml-3 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition">
                                        Copy
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Webhook Secret</label>
                                <input type="text" name="webhook_secret" value="{{ old('webhook_secret', $setting->webhook_secret) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition-all">
                            Save Integration
                        </button>
                    </form>
                </div>

                {{-- 🧾 Invoice Configuration --}}
                <div id="tab-content-invoice" class="hidden">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Invoice Configuration</h2>

                    <form method="POST" action="{{ route('settings.invoice.update') }}" class="space-y-6">
                        @csrf

                        <!-- Tax ID -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Tax ID</label>
                            <input type="text" name="tax_id_invoice"
                                   value="{{ old('tax_id_invoice', $setting->tax_id) }}"
                                   class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="123-456-789">
                        </div>

                        <!-- Starting Invoice Number -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Starting Invoice Number</label>
                            <input type="text"
                                   name="starting_invoice_number"
                                   value="{{ old('starting_invoice_number', $setting->starting_invoice_number ?? 'INV-' . date('Y') . '-001') }}"
                                   class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="INV-2025-001"
                                   pattern="^INV-\d{4}-\d{3,}$"
                                   title="Use the format INV-YYYY-NNN (e.g., INV-2025-001)">
                            <p class="text-sm text-gray-500 mt-1">
                                Set the starting invoice number. The next invoices will auto-increment from this number.
                                <br>Format: <code>INV-YYYY-NNN</code> (e.g., <code>INV-{{ date('Y') }}-001</code>)
                            </p>
                        </div>

                        <!-- Switches -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <!-- Enable Terms & Conditions -->
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Enable Terms & Conditions</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_terms" value="1" class="sr-only peer" {{ old('enable_terms', $setting->enable_terms) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md peer-checked:translate-x-5 transition-transform"></div>
                                </label>
                            </div>

                            <!-- Enable Invoice Notes -->
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Enable Invoice Notes</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_invoice_notes" value="1" class="sr-only peer" {{ old('enable_invoice_notes', $setting->enable_invoice_notes) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md peer-checked:translate-x-5 transition-transform"></div>
                                </label>
                            </div>


                            <!-- Enable Due Date -->
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Enable Due Date</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_due_date" value="1" class="sr-only peer" {{ old('enable_due_date', $setting->enable_due_date) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md peer-checked:translate-x-5 transition-transform"></div>
                                </label>
                            </div>

                            <!-- Enable Tax -->
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Enable Tax</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_tax" value="1" class="sr-only peer" {{ old('enable_tax', $setting->enable_tax) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md peer-checked:translate-x-5 transition-transform"></div>
                                </label>
                            </div>

                            <!-- Enable Tax ID -->
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-gray-700 font-medium">Enable Tax ID</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_tax_id" value="1" class="sr-only peer"
                                        {{ old('enable_tax_id', $setting->enable_tax_id) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md peer-checked:translate-x-5 transition-transform"></div>
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition-all mt-4">
                            Save Invoice Settings
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- SweetAlert2 (for copy notification) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('logo-input').addEventListener('change', function (event) {
            console.log('Logo input changed'); // ✅ debug
            const file = event.target.files[0];
            const preview = document.getElementById('logo-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        });
    </script>

    <script>
        // 🔹 Live preview for uploaded logo

        function copyWebhook(url) {
            navigator.clipboard.writeText(url).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Webhook URL Copied!',
                    text: 'The webhook URL has been copied to your clipboard.',
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'bottom-end',
                    toast: true,
                    background: '#fff',
                    color: '#333',
                    customClass: {
                        popup: 'rounded-lg shadow-md'
                    }
                });
            });
        }

        const tabs = {
            org: document.getElementById('tab-org'),
            int: document.getElementById('tab-int'),
            invoice: document.getElementById('tab-invoice'),
            sec: document.getElementById('tab-security'),
            noti: document.getElementById('tab-notifications'),
            contentOrg: document.getElementById('tab-content-org'),
            contentInt: document.getElementById('tab-content-int'),
            contentInvoice: document.getElementById('tab-content-invoice'),
        };

        function switchTab(activeTab, activeContent) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('text-blue-600', 'bg-blue-50', 'border-blue-600');
                btn.classList.add('text-gray-600', 'border-transparent');
            });
            activeTab.classList.add('text-blue-600', 'bg-blue-50', 'border-blue-600');

            document.querySelectorAll('[id^="tab-content-"]').forEach(content => content.classList.add('hidden'));
            activeContent.classList.remove('hidden');
        }

        tabs.org.addEventListener('click', () => switchTab(tabs.org, tabs.contentOrg));
        tabs.int.addEventListener('click', () => switchTab(tabs.int, tabs.contentInt));
        tabs.invoice.addEventListener('click', () => switchTab(tabs.invoice, tabs.contentInvoice));
    </script>
@endsection
