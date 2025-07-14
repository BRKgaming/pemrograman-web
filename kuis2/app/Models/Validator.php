<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Validator extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'validators';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'role',
        'name'
    ];

    protected $hidden = [
        'remember_token',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->user->password;
    }

    /**
     * Check if the validator is an officer
     */
    public function isOfficer()
    {
        return $this->role === 'officer';
    }

    /**
     * Check if the validator is a validator
     */
    public function isValidator()
    {
        return $this->role === 'validator';
    }

    /**
     * Relationship with Validations
     */
    public function validations()
    {
        return $this->hasMany(Validation::class);
    }
}
