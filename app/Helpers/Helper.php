<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use TicketSettings;

class Helper
{

    use FrontHelpers;
    use BackHelpers;
    use CalculatorHelpers;
    use InvoiceHelpers;


    public static function new()
    {
        return new self;
    }

    public function getName(): string
    {
        return "Abdelghafour Elmarzougui";
    }

    public function image($path)
    {
        return Storage::url($path);
    }

    public function ticketSetting(): TicketSettings
    {
        return app(TicketSettings::class);
    }
}
