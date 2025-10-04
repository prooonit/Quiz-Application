<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'created_by',
    ];

    // Quiz belongs to a user (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Quiz has many questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Quiz has many attempts
    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }
}
