<?php

namespace App\Models\Utilities;

use App\Models\Ticket;
use App\Traits\GetModelByUuid;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    use GetModelByUuid;
    use UuidGenerator;

    protected $fillable = [
        'name',
        'slug',
        'active'
    ];

    protected  $casts = [

        'tickets.pivot.start_at' => 'date',
        'tickets.pivot.end_at' => 'date'
    ];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_status', 'status_id', 'ticket_id')
        ->withPivot(['description','start_at','end_at','ticket_stop'])
        ->withTimestamps();
    }




    /*public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_status')
            ->using(TicketStatus::class)
            ->withPivot(['description', 'start_at', 'end_at', 'ticket_stop'])
            ->withTimestamps();
    }*/
}
