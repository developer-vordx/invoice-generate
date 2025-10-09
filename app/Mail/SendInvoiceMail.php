<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
class SendInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate PDF from Blade view
        $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $this->invoice]);

        return $this->subject('Your Invoice #' . $this->invoice->invoice_number)
            ->view('emails.invoices.sendinvoice')
            ->attachData($pdf->output(), 'invoice-' . $this->invoice->invoice_number . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
