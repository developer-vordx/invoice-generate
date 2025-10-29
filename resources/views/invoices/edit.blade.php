@extends('layouts.auth.app')

@section('title', 'Edit Invoice - ReconX')
<?php $hideNavbar = true; ?>

@section('content')
    <main class="flex-1 overflow-y-auto p-8">
        <div class="max-w-4xl mx-auto bg-white p-12 rounded-xl shadow-sm border border-gray-100">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Invoice #{{ $invoice->invoice_number }}</h1>

            <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                @csrf
                @method('PUT')

                {{-- Customer Information --}}
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>
                        <input type="text" name="customer_name" value="{{ $invoice->customer->name ?? '' }}"
                               class="w-full px-4 py-3 border rounded-lg bg-gray-100 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer Email</label>
                        <input type="text" name="customer_email" value="{{ $invoice->customer->email ?? '' }}"
                               class="w-full px-4 py-3 border rounded-lg bg-gray-100 cursor-not-allowed" disabled>
                    </div>
                </div>

                {{-- PROJECT ADDRESS FIELD --}}
                <div class="mb-8">
                    <label for="project_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Address
                    </label>
                    <input
                        id="project_address"
                        name="project_address"
                        type="text"
                        value="{{ old('project_address', $invoice->project_address) }}"
                        placeholder="Start typing the address..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                        autocomplete="off">

                    <p class="text-xs text-gray-500 mt-2">
                        Start typing to search for a U.S. address — or enter it manually if it doesn’t appear.
                    </p>
                    @error('project_address')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PROJECT NOTES FIELD --}}
                <div class="mb-8">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Project Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="4"
                        placeholder="Enter any project notes..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">{{ old('notes', $invoice->notes) }}</textarea>
                    @error('notes')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SAVE BUTTON --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- Google Maps Places API --}}
    <script>
        let autocomplete;
        function initAutocomplete() {
            const input = document.getElementById("project_address");
            if (!input) return;

            autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['address'],
                componentRestrictions: { country: 'us' },
                fields: ['formatted_address']
            });

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (place && place.formatted_address) {
                    input.value = place.formatted_address;
                }
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.places_api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
@endsection
