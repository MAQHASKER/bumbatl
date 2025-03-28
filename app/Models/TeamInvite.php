<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamInvite extends Model
{
    protected $fillable = [
        'uid',
        'team_id',
        'inviter_id',
        'email',
        'user_id',
        'is_accepted',
        'expires_at'
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
        'expires_at' => 'datetime'
    ];

    // Создаем уникальный UID при создании приглашения
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invite) {
            $invite->uid = Str::random(32);
        });
    }

    // Отношения
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
