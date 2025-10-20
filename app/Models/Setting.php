<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'tax_id',
        'country',
        'base_currency',
        'address',
        'logo_path',
        'invoice_notes',
        'invoice_terms',
        'tax_percentage',
        'stripe_public_key',
        'stripe_secret_key',
        'webhook_url',
        'webhook_secret',
        'contact_email',
    ];


    protected static function booted()
    {
        // Handle cache refresh automatically when settings change
        static::saved(function ($setting) {
            Cache::forget('app_settings');

            Cache::rememberForever('app_settings', function () {
                return Setting::first();
            });
        });

        static::deleted(function ($setting) {
            Cache::forget('app_settings');
        });
    }
}
