<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('settings.index', compact('setting'));
    }

    public function updateOrganization(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'base_currency' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $setting = Setting::firstOrNew();
        $setting->fill($validated)->save();

        return back()->with('success', 'Organization settings updated successfully.');
    }

    public function updateIntegration(Request $request)
    {
        $validated = $request->validate([
            'stripe_public_key' => 'nullable|string|max:255',
            'stripe_secret_key' => 'nullable|string|max:255',
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string|max:255',
        ]);

        $setting = Setting::firstOrNew();
        $setting->fill($validated)->save();

        return back()->with('success', 'Integration settings updated successfully.');
    }
}
