<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Fetch products dynamically (AJAX) with optional search.
     *
     * Supports:
     * - Live search for product name or SKU.
     * - Optional pagination limit.
     * - Returns JSON formatted for dropdowns or autocomplete.
     */
    public function fetch(Request $request)
    {
        try {
            $query = Product::query()->where('is_active', true);

            // Apply search filter (name or SKU)
            if ($request->filled('q')) {
                $search = $request->get('q');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            }

            // Optional: limit results for dropdown/autocomplete
            $limit = $request->get('limit', 10);
            $products = $query->orderBy('name')->limit($limit)->get();

            return response()->json([
                'success' => true,
                'data' => $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'label' => "{$product->name} ({$product->sku}) - $ {$product->price}",
                    ];
                })
            ]);
        } catch (\Throwable $e) {
            Log::error('Error fetching products (AJAX): ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Unable to fetch products.'], 500);
        }
    }

    /**
     * AJAX search endpoint for DataTables or global product list search.
     * Returns paginated JSON response.
     */
    public function search(Request $request)
    {
        try {
            $search = $request->get('search');
            $query = Product::query();

            if (!empty($search)) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }

            $products = $query->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $products->items(),
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                ]
            ]);
        } catch (\Throwable $e) {
            Log::error('Error during product search: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Search failed.'], 500);
        }
    }
}
