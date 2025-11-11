<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\WebhookSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        // Get webhook settings (or create a new instance if none exists)
        $webhookSetting = WebhookSetting::first() ?? new WebhookSetting();

        return view('settings.index', compact('setting', 'webhookSetting'));
    }

    public function updateOrganization(Request $request)
    {
        $validated = $request->validate([
            'company_name'     => 'required|string|max:255',
            'tax_id'           => 'nullable|string|max:255',
            'country'          => 'nullable|string|max:255',
            'base_currency'    => 'nullable|string|max:10',
            'address'          => 'nullable|string',
            'invoice_notes'    => 'nullable|string',
            'invoice_terms'    => 'nullable|string',
            'contact_email'    => 'nullable|string',
            'tax_percentage'   => 'nullable|numeric|min:0|max:100',
            'logo_path'             => 'nullable|image|mimes:jpg,webp,jpeg,png,svg|max:2048',
        ]);

        $setting = \App\Models\Setting::firstOrNew();

        // Handle logo upload
        // 🔹 Handle logo upload
        if ($request->hasFile('logo_path')) {
            // Delete old logo if exists
            if ($setting->logo_path && Storage::disk('public')->exists($setting->logo_path)) {
                Storage::disk('public')->delete($setting->logo_path);
            }

            // Store new logo
            $path = $request->file('logo_path')->store('logos', 'public');
            $validated['logo_path'] = $path;
        }

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
            'google_places_key' => 'nullable|string',
        ]);

        $setting = Setting::firstOrNew();
        $setting->fill($validated)->save();

        return back()->with('success', 'Integration settings updated successfully.');
    }

    public function updateInvoice(Request $request)
    {
        $validated = $request->validate([
            'tax_id_invoice' => 'nullable|string|max:255',
            'enable_tax_id' => 'nullable|boolean',
            'enable_terms' => 'nullable|boolean',
            'enable_invoice_notes' => 'nullable|boolean',
            'enable_tax' => 'nullable|boolean',
            'enable_due_date' => 'nullable|boolean',
            'starting_invoice_number' => [
                'required',
                'string',
                'regex:/^INV-\d{4}-\d{3,}$/', // e.g., INV-2025-001
            ],
        ], [
            'starting_invoice_number.regex' => 'The starting invoice number must follow the format INV-YYYY-NNN (e.g., INV-2025-001).',
        ]);

        $setting = Setting::firstOrNew();

        $setting->fill([
            'tax_id' => $validated['tax_id_invoice'] ?? null,
            'enable_tax_id' => $request->has('enable_tax_id'),
            'enable_terms' => $request->has('enable_terms'),
            'enable_invoice_notes' => $request->has('enable_invoice_notes'),
            'enable_tax' => $request->has('enable_tax'),
            'enable_due_date' => $request->has('enable_due_date'),
            'starting_invoice_number' => $validated['starting_invoice_number'],
        ])->save();

        return back()->with('success', 'Invoice settings updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
