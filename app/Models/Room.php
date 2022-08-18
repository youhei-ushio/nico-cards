<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'room_users',
            foreignPivotKey: 'room_id',
            relatedPivotKey: 'user_id')
            ->orderByPivot('created_at');
    }
}
