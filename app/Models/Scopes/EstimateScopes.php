<?php

namespace App\Models\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait EstimateScopes
{

    public function scopeFiltersStatus($query, $status)
    {
        return $query->where('status',  $status);
    }

    public function scopeFiltersClients($query, $client)
    {

        return $query->whereClientId($client);
    }

    public function scopeFiltersCompanies($query, $company)
    {
        //$company = Company::whereUuid($company)->firstOrFail()->id;

        return $query->where('company_id', $company);
    }

    public function scopeFiltersSend($query, $send)
    {
        //$company = Company::whereUuid($company)->firstOrFail()->id;

        return $query->where('is_send', $send);
    }

    public function scopeFiltersDateEstimate(Builder $query, $from): Builder
    {

        return $query->whereDate('created_at', Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d'));  
        
    }
}
