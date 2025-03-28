<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'max_members',
        'total_weight',
        'rank',
        'captain_id'
    ];

    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_user')
            ->withPivot('is_active')
            ->withTimestamps();
    }
}
