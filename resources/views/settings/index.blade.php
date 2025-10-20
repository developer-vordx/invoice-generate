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
                                <label class="block text-gray-600 font-medium mb-2">Tax ID</label>
                                <input type="text" name="tax_id"
                                       value="{{ old('tax_id', $setting->tax_id) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                                <input type="file" name="logo" accept="image/*"
                                       class="w-full border border-gray-300 rounded-lg p-2.5">
                                @if($setting->logo)
                                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="w-20 mt-2 rounded">
                                @endif
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
            </div>
        </div>
    </div>

    <!-- SweetAlert2 (for copy notification) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
            sec: document.getElementById('tab-security'),
            noti: document.getElementById('tab-notifications'),
            contentOrg: document.getElementById('tab-content-org'),
            contentInt: document.getElementById('tab-content-int'),
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
    </script>
@endsection
