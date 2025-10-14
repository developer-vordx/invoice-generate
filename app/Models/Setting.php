<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'tax_percentage',
        'stripe_public_key',
        'stripe_secret_key',
        'webhook_url',
        'webhook_secret',
    ];
}
