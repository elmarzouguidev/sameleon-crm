<?php

declare(strict_types=1);

namespace App\Models\Utilities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TicketStatus extends Pivot
{

    protected $table = 'ticket_status';

    protected  $casts = [
        'start_at' => 'date',
        'end_at' => 'date'
    ];
    
    protected $dates = ['start_at'];
    // Relationships

    // Helper Methods
}
