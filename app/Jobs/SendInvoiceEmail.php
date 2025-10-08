<?php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable; // ✅ Add this
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels; // ✅ Include Dispatchable

    protected $invoice;
    protected $pdfPath;
    protected $checkoutUrl;

    public function __construct(Invoice $invoice, $pdfPath, $checkoutUrl)
    {
        $this->invoice = $invoice;
        $this->pdfPath = $pdfPath;
        $this->checkoutUrl = $checkoutUrl;
    }

    public function handle()
    {
        Mail::to($this->invoice->customer->email)->send(
            new InvoiceMail($this->invoice, $this->pdfPath, $this->checkoutUrl)
        );
    }
}
