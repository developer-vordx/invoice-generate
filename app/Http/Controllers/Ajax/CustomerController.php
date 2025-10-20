<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function fetch(Request $request)
    {
        $search = $request->get('q', '');

        try {
            $customers = \App\Models\Customer::query()
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            // If no customers found, you can handle it gracefully
            if ($customers->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'No customers found.'
                ]);
            }

            $results = $customers->map(function ($c) {
                return [
                    'id' => $c->id,
                    'text' => "{$c->name} ({$c->email})",
                    'name' => $c->name,
                    'company_name' => $c->company_name,
                    'email' => $c->email,
                    'address' => $c->address,
                    'city' => $c->city,
                    'country' => $c->country,
                ];
            });

            return response()->json(['success' => true, 'data' => $results]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}

