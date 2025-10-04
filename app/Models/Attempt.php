<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'total',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // Attempt belongs to a quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Attempt belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attempt has many attempt answers
    public function answers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
