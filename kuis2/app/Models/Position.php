<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model
     *
     * @var string
     */
    protected $table = 'available_positions';

    /**
     * Kolom yang dapat diisi massal
     *
     * @var array
     */
    protected $fillable = [
        'job_vacancy_id',
        'position',
        'capacity',
        'apply_capacity'
    ];

    /**
     * Relasi ke model JobVacancy
     */
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    /**
     * Relasi ke model JobApplyPosition (banyak posisi yang dilamar)
     */
    public function jobApplications()
    {
        return $this->hasMany(JobApplyPosition::class, 'position_id');
    }

    /**
     * Accessor untuk menghitung jumlah pelamar
     */
    public function getApplicantsCountAttribute()
    {
        return $this->jobApplications()->count();
    }

    /**
     * Accessor untuk mengecek apakah posisi masih tersedia
     */
    public function getIsAvailableAttribute()
    {
        return $this->applicants_count < $this->capacity;
    }

    /**
     * Scope untuk posisi yang tersedia
     */
    public function scopeAvailable($query)
    {
        return $query->whereRaw('(SELECT COUNT(*) FROM job_apply_positions WHERE position_id = available_positions.id) < capacity');
    }
}
