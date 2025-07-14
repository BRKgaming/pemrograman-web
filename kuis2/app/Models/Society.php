<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Society extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'societies';

    protected $fillable = [
        'id_card_number',
        'password',
        'name',
        'born_date',
        'gender',
        'address',
        'regional_id',
        'login_tokens'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'login_tokens' // Sembunyikan juga login_tokens dari response
    ];

    /**
     * Relationship to Validation
     */
    public function validation()
    {
        return $this->hasOne(Validation::class, 'society_id');
    }

    /**
     * Relationship to Job Applications
     * Menggunakan table job_apply_societies yang sesuai dengan database
     */
    public function applications()
    {
        return $this->hasMany(JobApplySociety::class, 'society_id');
    }

    /**
     * Relationship alias untuk kompatibilitas dengan kode lama
     * Jika di view masih menggunakan $user->jobApplySocieties
     */
    public function jobApplySocieties()
    {
        return $this->applications();
    }

    /**
     * Relationship to Regional
     */
    public function regional()
    {
        return $this->belongsTo(Regional::class, 'regional_id');
    }

    /**
     * Authentication methods
     */
    public function getAuthIdentifierName()
    {
        return 'id_card_number';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['id_card_number'];
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    /**
     * Generate token untuk login
     */
    public function generateToken()
    {
        $this->login_tokens = md5($this->id_card_number . time());
        $this->save();
        return $this->login_tokens;
    }

    /**
     * Cek apakah society sudah melakukan validasi
     */
    public function hasValidation()
    {
        return $this->validation()->exists();
    }
}