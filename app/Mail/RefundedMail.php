<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $pdf;

    public function __construct($invoice, $pdf)
    {
        $this->invoice = $invoice;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Your Refunded Invoice #' . $this->invoice['number'])
            ->view('emails.refunded')
            ->with(['invoice' => $this->invoice])
            ->attachData($this->pdf, 'invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
