<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateTicketSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('ticket.start_from', 6524);
        $this->migrator->add('ticket.prefix', '#TCK');
    }
}
