<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttemptAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option_ids',
        'text_answer',
        'is_correct',
    ];

    protected $casts = [
        'selected_option_ids' => 'array',
    ];

    // Belongs to attempt
    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }

    // Belongs to question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
