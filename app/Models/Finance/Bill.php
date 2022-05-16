<?php

namespace App\Models\Finance;

use App\Models\Client;
use App\Traits\GetModelByUuid;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    use HasFactory;
    use UuidGenerator;
    use GetModelByUuid;


    protected $fillable = [
        'bill_date',
        'bill_mode',
        'reference',
        'notes',
        'price_ht',
        'price_total',
        'price_tva',
        'billable_id',
        'billable_type',
    ];

    protected  $casts = [
        'bill_date' => 'date:Y-m-d',
    ];

    public function billable()
    {
        return $this->morphTo();
    }

    /* public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }*/


    public function getFormatedPriceHtAttribute()
    {
        return number_format($this->price_ht, 2);
    }

    public function getFormatedPriceTotalAttribute()
    {
        return number_format($this->price_total, 2);
    }

    public function getFormatedPriceTvaAttribute()
    {
        return number_format($this->price_tva, 2);
    }
    public function getEditUrlAttribute()
    {
        return route('commercial:bills.edit', $this->uuid);
    }

    public static function boot()
    {

        parent::boot();

        static::creating(function ($model) {

            /*$model->bill_code = $model->invoice->invoice_code;

            $model->full_number = 'REGL-' . $model->invoice->full_number;*/

            $number = self::max('id') + 1;
            $model->code = str_pad($number, 5, 0, STR_PAD_LEFT);
            $model->full_number = 'REGL-' . str_pad($number, 5, 0, STR_PAD_LEFT);
        });
    }
}
