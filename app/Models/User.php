<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>`
     */
    protected $hidden = [
        'workos_id',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Boot the model.
     *
     * Listen for the creating event and set a unique identifier on the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uniqueKey = Str::ulid();
        });
    }
}
