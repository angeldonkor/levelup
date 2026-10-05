<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'participation_id',
        'result_date',
        'value',
        'proof_url',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'result_date' => 'date',
        'value' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public function participation()
    {
        return $this->belongsTo(Participation::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}