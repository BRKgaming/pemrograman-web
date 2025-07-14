<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relationship with Validator
     */
    public function validator()
    {
        return $this->hasOne(Validator::class);
    }
}

