<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'activity',
        'description',
        'amount',
        'quantity',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }


}
