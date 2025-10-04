<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'type',
        'text',
        'expected_answer',
        'text_answer_limit',
        'points',
    ];

    // Question belongs to a quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Question has many options
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    // Question has many attempt answers
    public function attemptAnswers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
