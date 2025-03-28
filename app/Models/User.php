<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'about',
        'is_active',
        'role',
        'team_id'
    ];

    /**
     * Атрибуты, которые должны быть скрыты для сериализации.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Атрибуты, которые должны быть приведены к нативным типам.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Получить полное имя пользователя.
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
            ->withPivot('is_active')
            ->withTimestamps();
    }
}
