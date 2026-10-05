<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'name',
        'unit',
        'start_date',
        'end_date',
        'rules',
        'min_value',
        'max_value',
        'leaderboard_published',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
        'leaderboard_published' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
}