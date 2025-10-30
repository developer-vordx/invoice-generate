<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InvoiceActivity extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'customer_id',
        'activity_type',
        'message',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
