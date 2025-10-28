<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_number',
        'description',
        'amount',
        'issue_date',
        'due_date',
        'status',
        'note',
        'user_responded',
        'payment_gateway',
        'gateway_transaction_id',
        'gateway_response',
        'payment_status',
    ];

    protected $casts = [
        'gateway_response' => 'array',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Consume the next invoice number.
     * Reads directly from the settings table (not cache),
     * increments it, updates the setting,
     * and returns the number used for this invoice.
     *
     * @return string
     */
    public static function consumeNextInvoiceNumber()
    {
        return DB::transaction(function () {
            // Get the latest settings row directly from DB
            $settings = Setting::first();

            // Fallback if not set
            $currentNumber = $settings->starting_invoice_number ?? 'INV-' . date('Y') . '-001';

            // Generate the next number
            $newNextNumber = self::incrementInvoiceNumber($currentNumber);

            // Update the setting (Setting model auto-refreshes cache)
            $settings->update(['starting_invoice_number' => $newNextNumber]);

            // Return the current number for invoice creation
            return $currentNumber;
        });
    }

    /**
     * Increment invoice number (INV-2025-001 → INV-2025-002)
     */
    protected static function incrementInvoiceNumber($number)
    {
        if (!preg_match('/^([A-Z]+)-(\d{4})-(\d+)$/', $number, $matches)) {
            $prefix = 'INV';
            $year = date('Y');
            $num = 1;
        } else {
            [$full, $prefix, $year, $num] = $matches;
            $num = (int) $num;

            // Reset each year
            if ($year != date('Y')) {
                $year = date('Y');
                $num = 1;
            } else {
                $num++;
            }
        }

        return sprintf('%s-%s-%03d', $prefix, $year, $num);
    }


}
