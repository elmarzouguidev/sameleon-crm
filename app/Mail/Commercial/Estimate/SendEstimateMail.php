<?php

namespace App\Mail\Commercial\Estimate;

use App\Models\Finance\Estimate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendEstimateMail extends Mailable
{
    use Queueable, SerializesModels;


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

        $estimate = $this->data;
        $hasHeader = true;
        $companyLogo = public_path('storage/' . $logo);

        $pdf = \PDF::loadView('theme.estimates_template.template1.index', compact('estimate', 'companyLogo','hasHeader'));

        return $this->from('noreplay@casamaintenance.ma', Str::upper($this->data->company->name))
            ->subject('DEVIS N°: ' . $this->data->code)
            ->view('theme.Emails.Commercial.Estimate.SendEstimateMail')
            ->with('data', (object)$this->data)
            ->attachData($pdf->output(), 'DEVIS-' . $this->data->code . '.pdf', [
                'mime' => 'application/pdf',
            ]);

    }

}
