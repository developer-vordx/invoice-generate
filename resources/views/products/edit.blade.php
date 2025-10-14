@extends('layouts.auth.app')

@section('title', 'Edit Product - ' . config('app.name', 'ReconX'))

@section('content')
    <div class="w-full max-w-3xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Product</h1>
                <p class="text-gray-500 mt-1">Modify product details and save changes.</p>
            </div>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('products.update', $product->id) }}" method="POST"
              class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 transition-all hover:shadow-lg">
            @csrf
            @method('PUT')

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Fields Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Product Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-blue-600 mr-1"></i> Product Name
                    </label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="Enter product name" required>
                </div>

                {{-- SKU --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-barcode text-blue-600 mr-1"></i> SKU
                    </label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="e.g. PROD-001">
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign text-blue-600 mr-1"></i> Price
                    </label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="e.g. 199.99" required>
                </div>

                {{-- Stock --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-boxes text-blue-600 mr-1"></i> Stock
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                           placeholder="Stock quantity">
                </div>
            </div>

            {{-- Description --}}
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-align-left text-blue-600 mr-1"></i> Description
                </label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400 resize-none"
                          placeholder="Write a short description about this product...">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Active Toggle --}}
            <div class="mt-6 flex items-center justify-between">
                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="is_active" value="1" class="hidden peer" {{ $product->is_active ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-blue-600 relative transition">
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md peer-checked:translate-x-5 transition"></div>
                    </div>
                    <span class="text-sm text-gray-700 font-medium">Active</span>
                </label>
                <p class="text-gray-400 text-sm italic">
                    {{ $product->is_active ? 'Currently visible in your catalog' : 'Currently hidden from your catalog' }}
                </p>
            </div>

            {{-- Buttons --}}
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('products.index') }}"
                   class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition">
                    <i class="fas fa-save mr-2"></i> Update Product
                </button>
            </div>
        </form>
    </div>
@endsection
