<?php

use Spatie\LaravelSettings\Settings;

class TicketSettings extends Settings
{
    public int $start_from;

    public string $prefix;

    public static function group(): string
    {
        return 'ticket';
    }
}
