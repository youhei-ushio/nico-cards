<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class EventMessage extends Model
{
    use HasFactory;

    protected $table = 'event_messages';

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'updated_at',
    ];
}
