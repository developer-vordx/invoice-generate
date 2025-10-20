<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function fetch(Request $request)
    {
        $search = $request->get('q', '');

        $customers = \App\Models\Customer::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        $results = $customers->map(function ($c) {
            return [
                'id' => $c->id,
                'text' => "{$c->name} ({$c->email})",
                'name' => $c->name,
                'company_name' => $c->company_name,
                'email' => $c->email,
                'address' => $c->address,
                'city' => $c->city,
            ];
        });

        return response()->json(['success' => true, 'data' => $results]);
    }


}
