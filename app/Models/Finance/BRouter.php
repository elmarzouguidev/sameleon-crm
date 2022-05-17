<?php

declare(strict_types=1);

namespace App\Models\Finance;

use App\Models\Utilities\History;
use App\Traits\GetModelByUuid;
use App\Traits\UuidGenerator;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;


class BRouter extends Model
{
    use HasFactory;
    use HasFactory;
    use UuidGenerator;
    use GetModelByUuid;

    /**
     * @var string[]|array<int,string>
     */
    protected $fillable = [];

    /**
     * @var string[]|array<int,string>
     */
    protected $casts = [];

    // Relationships

    // Helper Methods

    public function scopeFiltersDateBr(Builder $query, $from): Builder
    {
        return $query->whereDate('created_at', Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d'));  
    }
    
    public static function boot()
    {

        parent::boot();

        static::creating(function ($model) {

            if (self::count() <= 0) {

                $number = getDocument()->br_start;
            } else {

                $number = ($model->max('code') + 1);
            }

            $code = str_pad($number, 5, 0, STR_PAD_LEFT);

            $model->code = $code;

            $model->full_number = getDocument()->br_prefix . $code;
        });
    }
}
