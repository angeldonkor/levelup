<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
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
        ];
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function createdChallenges()
    {
        return $this->hasMany(Challenge::class, 'created_by');
    }

    public function reviewedResults()
    {
        return $this->hasMany(Result::class, 'reviewed_by');
    }

    public function isCoach(): bool
    {
        return $this->role === 'coach';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }
}