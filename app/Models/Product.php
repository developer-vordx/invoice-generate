<?php

namespace App\Models;

use App\Traits\WebhookEventTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,WebhookEventTrait;
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'is_active'
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
