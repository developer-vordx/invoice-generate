<?php
namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $pdfPath;
    public $checkoutUrl;

    public function __construct(Invoice $invoice, $pdfPath, $checkoutUrl)
    {
        $this->invoice = $invoice;
        $this->pdfPath = $pdfPath;
        $this->checkoutUrl = $checkoutUrl;
    }

    public function build()
    {
        return $this->subject("Invoice #{$this->invoice->invoice_number}")
            ->markdown('emails.invoice')
//            ->attach($this->pdfPath, ['as' => 'invoice.pdf'])
            ->with([
                'invoice' => $this->invoice,
                'checkoutUrl' => $this->checkoutUrl,
            ]);
    }
}
