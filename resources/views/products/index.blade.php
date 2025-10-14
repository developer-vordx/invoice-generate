@extends('layouts.auth.app')

@section('title', 'Products - ' . config('app.name', 'ReconX'))

@section('content')
    <div class="w-full max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Products</h1>
            <div class="space-x-2">
                <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Add Product
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Products Table -->
        <div class="bg-white shadow rounded-xl border border-gray-100 overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead>
                <tr class="bg-gray-50 text-left text-gray-600 uppercase text-sm">
                    <th class="p-4 border-b">Name</th>
                    <th class="p-4 border-b">SKU</th>
                    <th class="p-4 border-b">Price</th>
                    <th class="p-4 border-b">Stock</th>
                    <th class="p-4 border-b">Status</th>
                    <th class="p-4 border-b text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 border-b">{{ $product->name }}</td>
                        <td class="p-4 border-b">{{ $product->sku ?? 'N/A' }}</td>
                        <td class="p-4 border-b">${{ number_format($product->price, 2) }}</td>
                        <td class="p-4 border-b">{{ $product->stock }}</td>
                        <td class="p-4 border-b">
                            @if($product->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Active</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Disabled</span>
                            @endif
                        </td>
                        <td class="p-4 border-b text-right space-x-2">
                            <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:underline">View</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">No products found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
