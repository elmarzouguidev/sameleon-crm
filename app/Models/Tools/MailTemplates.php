<?php

declare(strict_types=1);

namespace App\Models\Tools;

use App\Traits\GetModelByUuid;
use App\Traits\HasSlug;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MailTemplates extends Model
{
    use HasFactory;
    use UuidGenerator;
    use HasSlug;
    use GetModelByUuid;

    protected $table="mail_templates";

    /**
     * @var string[]|array<int,string>
     */
    protected  $fillable = [
        'name',
        'content',
        'active'
    ];

    /**
     * @var string[]|array<int,string>
     */
    protected  $casts = [];

    // Relationships

    // Helper Methods
}
