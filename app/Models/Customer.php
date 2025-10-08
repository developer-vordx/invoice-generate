<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'stripe_customer_id',
        'name',
        'company_name',
        'email',
        'phone_number',
        'address',
        'postal_code',
        'city',
        'state',
        'country',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
