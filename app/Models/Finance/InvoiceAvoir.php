<?php

namespace App\Models\Finance;

use App\Models\Client;
use App\Models\Ticket;
use App\Models\Utilities\History;
use App\Traits\GetModelByUuid;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class InvoiceAvoir extends Model
{
    use HasFactory;
    // use SoftDeletes;
    use GetModelByUuid;
    use UuidGenerator;

    protected $fillable = ['status', 'type', 'is_send'];

    protected  $casts = [
        'due_date' => 'date:Y-m-d',
        'invoice_date' => 'date:Y-m-d',
        'is_send' => 'boolean'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class)->withDefault();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function articles()
    {
        return $this->morphMany(Article::class, 'articleable');
    }

    public function bill()
    {
        return $this->morphOne(Bill::class, 'billable')->withDefault();
    }

    public function histories()
    {
        return $this->morphMany(History::class, 'historyable');
    }

    public function getFormatedPriceHtAttribute()
    {
        return number_format($this->price_ht, 2);
    }

    public function getFormatedPriceTotalAttribute()
    {
        return number_format($this->price_total, 2);
    }

    public function getFormatedTotalTvaAttribute()
    {
        return number_format($this->price_tva, 2);
    }

    public function getUrlAttribute()
    {
        return route('commercial:invoices.single.avoir', $this->uuid);
    }

    public function getEditUrlAttribute()
    {
        return route('commercial:invoices.edit.avoir', $this->uuid);
    }

    public function getUpdateUrlAttribute()
    {
        return route('commercial:invoices.update.avoir', $this->uuid);
    }

    public function getPdfUrlAttribute()
    {
        return route('commercial:invoices.pdf.build.avoir', $this->uuid);
    }

    public function getAddBillAttribute()
    {
        return route('commercial:bills.addBill.avoir', $this->uuid);
    }


    public function scopeFiltersDateInvoiceAvoir(Builder $query, $from): Builder
    {
        return $query->whereDate('created_at', Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d'));  
    }

    public function scopeFiltersClients(Builder $query, $client)
    {
        return $query->where('client_id', $client);
    }

    public function scopeFiltersCompanies(Builder $query, $company)
    {
        //$company = Company::whereUuid($company)->firstOrFail()->id;

        return $query->where('company_id', $company);
    }
    
    public static function boot()
    {

        parent::boot();

        static::creating(function ($model) {

            if ($model->company->invoicesAvoir->count() <= 0) {
                //dd('OOO empty');
                $number = $model->company->invoice_avoir_start_number;
            } else {
                //dd('Not empty ooo');
                $number = ($model->company->invoicesAvoir->max('code') + 1);
            }

            $invoiceCode = str_pad($number, 5, 0, STR_PAD_LEFT);

            $model->code = $invoiceCode;

            $model->full_number = $model->company->prefix_invoice_avoir . $invoiceCode;
        });
    }
}
