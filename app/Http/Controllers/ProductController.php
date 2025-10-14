<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index()
    {
        try {
            $products = Product::orderBy('created_at', 'desc')->paginate(10);
            return view('products.index', compact('products'));
        } catch (\Throwable $e) {
            Log::error('Error loading products: ' . $e->getMessage());
            return back()->with('error', 'Unable to load products. Please try again.');
        }
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        try {
            Product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
                'stock' => $request->stock ?? 0,
                'description' => $request->description,
                'is_active' => true,
            ]);

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Throwable $e) {

            Log::error('Error creating product: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create product. Please try again.');
        }
    }

    /**
     * Display the specified product with related invoices.
     */
    public function show(Product $product)
    {
        $invoices = \App\Models\Invoice::whereHas('items', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->with('customer')->get();

        $totalInvoices = $invoices->count();
        $paidInvoices = $invoices->where('status', 'paid')->count();
        $pendingInvoices = $invoices->where('status', '!=', 'paid')->count();

        return view('products.show', compact(
            'product',
            'invoices',
            'totalInvoices',
            'paidInvoices',
            'pendingInvoices'
        ));
    }


    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $product->update([
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
                'stock' => $request->stock ?? 0,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Throwable $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update product. Please try again.');
        }
    }

    /**
     * Remove (soft delete or hard delete) the specified product.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return back()->with('success', 'Product deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete product. Please try again.');
        }
    }

    /**
     * Toggle product active/inactive (via AJAX or route).
     */
    public function toggleStatus(Product $product)
    {
        try {
            $product->is_active = !$product->is_active;
            $product->save();

            return response()->json([
                'success' => true,
                'status' => $product->is_active ? 'active' : 'disabled'
            ]);
        } catch (\Throwable $e) {
            Log::error('Error toggling product status: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Unable to change status.'], 500);
        }
    }
}
