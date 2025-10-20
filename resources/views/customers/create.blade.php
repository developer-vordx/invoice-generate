@extends('layouts.auth.app')

@section('title', 'Add Customer - ' . config('app.name', 'ReconX'))

@section('content')
    <div class="w-full max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Add New Customer</h1>
                <p class="text-gray-500 mt-1">Fill in the customer details below to add them to your system.</p>
            </div>
            <a href="{{ route('customers.index') }}"
               class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <form action="{{ route('customers.store') }}" method="POST"
              class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 transition-all hover:shadow-lg">
            @csrf

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user mr-1 text-blue-600"></i> Name
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="Customer full name" required>
                </div>

                {{-- Company Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-building mr-1 text-blue-600"></i> Company Name
                    </label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="Company or organization name">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1 text-blue-600"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="customer@example.com" required>
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone mr-1 text-blue-600"></i> Phone Number
                    </label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="+1 555 123 4567">
                </div>

                {{-- Address --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-1 text-blue-600"></i> Address
                    </label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="Street address, P.O. Box, etc.">
                </div>

                {{-- City --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-city mr-1 text-blue-600"></i> City
                    </label>
                    <input type="text" name="city" value="{{ old('city') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="City">
                </div>

                {{-- State --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map mr-1 text-blue-600"></i> State
                    </label>
                    <input type="text" name="state" value="{{ old('state') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="State or province">
                </div>

                {{-- Postal Code --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-mail-bulk mr-1 text-blue-600"></i> Postal Code
                    </label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="ZIP / Postal code">
                </div>

                {{-- Country --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-flag mr-1 text-blue-600"></i> Country
                    </label>
                    <input type="text" name="country" value="{{ old('country') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="Country">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('customers.index') }}"
                   class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition">
                    <i class="fas fa-save mr-2"></i> Save Customer
                </button>
            </div>
        </form>
    </div>
@endsection
