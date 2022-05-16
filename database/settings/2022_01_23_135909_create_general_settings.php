<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('company.name', 'SAMELEON');
        $this->migrator->add('company.website', 'https://sameleon-express.ma');
        $this->migrator->add('company.logo', 'logo.png');
        $this->migrator->add('company.addresse', 'RUE SOUMAYA IMM 82 ETAGE04 N16 PALMIERS');
        $this->migrator->add('company.telephone_a', '+212664000165');
        $this->migrator->add('company.telephone_b', '+212664000169');
        $this->migrator->add('company.email', 'info@sameleon-express.ma');
        $this->migrator->add('company.rc', '507491');
        $this->migrator->add('company.ice', '002749195000015');
        $this->migrator->add('company.cnss', null);
        $this->migrator->add('company.patente', '34778172');
        $this->migrator->add('company.if', '50316039');
    }
}
