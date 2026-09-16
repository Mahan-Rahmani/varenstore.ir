<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    protected static function booted()
    {
        static::saving(function ($user) {
            if (in_array($user->phone, ['09395808412', '09199095508'])) {
                $user->role = UserRole::ADMIN;
            }
        });
    }

    public function isAdmin(): bool
    {
        if (in_array($this->phone, ['09395808412', '09199095508'])) {
            if ($this->role !== UserRole::ADMIN) {
                $this->role = UserRole::ADMIN;
                $this->saveQuietly();
            }
            return true;
        }

        return $this->role === UserRole::ADMIN;
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::CUSTOMER;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
