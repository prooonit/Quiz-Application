<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // A user can create many quizzes
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'created_by');
    }

    // A user can have many attempts
    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }
}
