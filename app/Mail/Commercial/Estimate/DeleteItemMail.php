<?php

declare(strict_types=1);

namespace App\Mail\Commercial\Estimate;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class DeleteItemMail extends Mailable
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

        $estimate = $this->data;
        $hasHeader = true;
        $companyLogo = public_path('storage/' . $logo);

        $pdf = \PDF::loadView('theme.estimates_template.template1.index', compact('estimate', 'companyLogo', 'hasHeader'));

        return $this->from('no-replay@' . request()->getHost(), Str::upper($this->data->company->name))
            ->subject('Alert de suppression DEVIS N°: ' . $this->data->code)
            ->view('theme.Emails.Commercial.Estimate.DeletedEstimateMail')
            ->with('data', (object)$this->data)
            ->attachData($pdf->output(), 'DEVIS-' . $this->data->code . '.pdf', [
                'mime' => 'application/pdf',
            ]);

    }
}
