<?php

declare(strict_types=1);

namespace App\Mail\Commercial\Invoice;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendInvoiceMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->data->load('articles', 'company', 'client');

        $logo = $this->data->company->logo;

        $invoice = $this->data;
        $hasHeader = true;
        $companyLogo = public_path('storage/' . $logo);

        $pdf = \PDF::loadView('theme.invoices_template.template1.index', compact('invoice', 'companyLogo','hasHeader'));

        return $this->from('noreplay@casamaintenance.ma', Str::upper($this->data->company->name))
            ->subject('FACTURE N°: ' . $this->data->code)
            ->view('theme.Emails.Commercial.Invoice.SendInvoiceMail')
            ->with('data', (object)$this->data)
            ->attachData($pdf->output(), 'FACTURE-' . $this->data->code . '.pdf', [
                'mime' => 'application/pdf',
            ]);

    }
}
