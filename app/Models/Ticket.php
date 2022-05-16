<?php

namespace App\Models;

use App\Collections\Ticket\TicketCollection;

use App\Constants\Etat;
use App\Models\Finance\Estimate;
use App\Models\Finance\Invoice;
use App\Models\Utilities\Comment;
use App\Models\Utilities\Delivery;
use App\Models\Utilities\History;
use App\Models\Utilities\Report;
use App\Models\Utilities\Status;
use \App\Constants\Status as TicketStatus;
use App\Models\Scopes\TicketScopes;
use App\Models\Utilities\Warranty;
use App\Traits\GetModelByUuid;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ticket extends Model implements HasMedia
{

    use HasFactory;
    use UuidGenerator;
    use GetModelByUuid;
    use InteractsWithMedia;
    //use SoftDeletes;

    use TicketScopes;

    protected $fillable = [
        'code',
        'code_retour',
        'is_retour',
        'retour_number',
        'article',
        'article_reference',
        'description',
        'photos',
        'etat',
        'status',
        'user_id',
        'can_invoiced',
        'livrable',
        'started_at',
        'finished_at',
        'can_make_report',
    ];

    protected  $casts = [
        'can_invoiced' => 'boolean',
        'livrable' => 'boolean',
        'etat' => 'integer',
        'status' => 'integer',
        'started_at' => 'date',
        'finished_at' => 'date',
        'can_make_report' => 'boolean',
        'is_retour' => 'boolean',

        'statuses.pivot.start_at' => 'date',
        'statuses.pivot.end_at' => 'date'
    ];
    protected $appends = ['code'];
    //protected static array $logAttributes = ['etat', 'status'];

    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'ticket_status', 'ticket_id', 'status_id')
            ->withPivot(['description', 'start_at', 'end_at', 'ticket_stop'])
            ->withTimestamps();
    }

    /* public function statuses()
    {
        return $this->belongsToMany(Status::class, 'ticket_status')->using(TicketStatus::class)
            ->withPivot(['description', 'start_at', 'end_at', 'ticket_stop'])
            ->withTimestamps();
    }*/

    public function newStatus()
    {
        return $this->belongsToMany(Status::class, 'ticket_status', 'ticket_id', 'status_id')
            ->orderBy('id', 'desc');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function estimate()
    {
        return $this->hasOne(Estimate::class);
    }

    public function estimates()
    {
        return $this->belongsToMany(Estimate::class, 'ticket_estimate', 'ticket_id', 'estimate_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class)->withDefault();
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'ticket_invoice', 'ticket_id', 'invoice_id');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'ticket_user', 'ticket_id', 'user_id');
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function diagnoseReports()
    {
        return $this->hasOne(Report::class)->where('type', 'diagnostique');
    }

    public function reparationReports()
    {
        return $this->hasOne(Report::class)->where('type', 'reparation');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function warranty()
    {
        return $this->hasOne(Warranty::class);
    }

    public function getUrlAttribute()
    {
        return route('admin:tickets.single', $this->uuid);
    }

    public function getEditAttribute()
    {
        return route('admin:tickets.edit', $this->uuid);
    }

    public function getUpdateUrlAttribute()
    {
        return route('admin:tickets.update', $this->uuid);
    }

    public function getTicketUrlAttribute()
    {
        return route('admin:tickets.diagnose', $this->uuid);
    }


    public function getDiagnoseUrlAttribute()
    {
        return route('admin:tickets.diagnose', $this->uuid);
    }

    public function getSendReportUrlAttribute()
    {
        return route('admin:tickets.diagnose.send-report', $this->uuid);
    }

    public function getRepearUrlAttribute()
    {
        return route('admin:reparations.single', $this->uuid);
    }


    public function getMediaUrlAttribute()
    {
        return route('admin:tickets.media', $this->uuid);
    }

    public function getHistoricalUrlAttribute()
    {
        return route('admin:tickets.historical', $this->uuid);
    }

    public function getFullDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at);
        return $date->translatedFormat('d') . ' ' . $date->translatedFormat('F') . ' ' . $date->translatedFormat('Y');
    }

    protected function shortDescription(): Attribute
    {
        return new Attribute(
            fn () => Str::limit($this->description, 100, ' (...)'),
        );
    }

    public function getCodeAttribute($code)
    {
        if($this->is_retour)
        {
          return  $this->getRawOriginal('code_retour');
        }
        else{
            return $this->getRawOriginal('code');
        }
       
    }


    public function scopeFiltersDateTicket(Builder $query, $from): Builder
    {
        return $query->whereDate('created_at', Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d'));  
    }

    public function scopeNewTickets($query)
    {
        return $query->where('user_id', null)->whereEtat(Etat::NON_DIAGNOSTIQUER)
            ->whereStatus(TicketStatus::NON_TRAITE)
            ->latest()->count();
    }

    public function scopeTicketsInvoiceable($query)
    {
        return $query->whereNotNull('user_id')->whereEtat(Etat::REPARABLE)
            ->where('can_invoiced', true)
            ->whereStatus(TicketStatus::PRET_A_ETRE_LIVRE)
            ->doesntHave('invoice')
            ->latest()->count();
    }

    public function scopeNewTicketsDiagnostic($query)
    {
        return $query->whereNotNull('user_id')->whereIn('etat', [Etat::NON_REPARABLE, Etat::REPARABLE])
            ->whereIn('status', [
                TicketStatus::EN_ATTENTE_DE_DEVIS,
                TicketStatus::RETOUR_NON_REPARABLE,
                TicketStatus::EN_ATTENTE_DE_BON_DE_COMMAND
            ])
            ->latest()->count();
    }

    public function scopeNewTicketsDiagnosticTech($query)
    {
        return $query->whereNotNull('user_id')->whereIn('etat', [Etat::NON_REPARABLE, Etat::REPARABLE])
            ->whereIn('status', [
                TicketStatus::EN_ATTENTE_DE_DEVIS,
                TicketStatus::A_REPARER
            ])
            ->latest()->count();
    }

    public function scopeTicketsLivrable($query, $etat)
    {
        return $query
            ->whereNotNull('user_id')
            ->whereLivrable($etat)
            ->whereIn('etat', [Etat::NON_REPARABLE, Etat::REPARABLE])
            ->whereIn('status', [TicketStatus::PRET_A_ETRE_LIVRE, TicketStatus::RETOUR_NON_REPARABLE, TicketStatus::RETOUR_DEVIS_NON_CONFIRME])
            ->latest()->count();
    }

    public function scopeOldTickets($query)
    {
        /*return $query->whereNotNull('user_id')->whereIn('etat', [Etat::NON_REPARABLE, Etat::REPARABLE])
            ->whereIn('status', [TicketStatus::LIVRE,TicketStatus::RETOUR_DEVIS_NON_CONFIRME,TicketStatus::RETOUR_NON_REPARABLE])->oldest();*/

        return $query->oldest();
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('normal')
            ->width(800)
            ->height(800)
            ->sharpen(10)
            ->optimize();
    }

    public function newCollection(array $models = [])
    {
        return new TicketCollection($models);
    }

    public function getAllPhotosAttribute()
    {
        $images = json_decode($this->images) ?? [];

        $collection = collect($images);

        $imagesPaths = $collection->map(function ($item, $key) {

            return Voyager::image($item);
        });

        return $imagesPaths->all();
        //return $images;
    }

    /***** */

    public static function boot()
    {
        parent::boot();

        $prefixer = config('app-config.tickets.prefix');
        $startFrom = config('app-config.tickets.start_from');

        static::creating(function ($model) use ($prefixer, $startFrom) {

            if (request()->has('is_retour') && request()->filled('is_retour') && request()->is_retour == 'on' && request()->filled('ticket_retoure')) {
                //dd('Oui is retour',request()->is_retour,request()->ticket_retoure);
                $ticket = self::whereId(request()->ticket_retoure)->first();

                $ticket->increment('retour_number');

                $num = $ticket->retour_number;

                $model->code_retour = $ticket->code . '-R-' . $num ;

                $model->is_retour = true;

                $model->code = 0000;
            }
            else{

                if (self::count() <= 0) {
                    //$number = $startFrom;
                    $number = \ticketApp::ticketSetting()->start_from;
                } else {
                    $number = (self::max('code') + 1);
                }
    
                // $model->code = $prefixer . str_pad($number, 5, 0, STR_PAD_LEFT);
                $model->code = $number;
            }


        });
    }
}
