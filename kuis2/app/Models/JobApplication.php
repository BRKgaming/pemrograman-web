<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\JobVacancy;


class JobApplication extends Model
{
    protected $fillable = [
        'society_id',
        'job_vacancy_id',
        'position_id',
        'notes',
        'status' // pending/accepted/rejected
    ];

    // Relasi ke Society
    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    // Relasi ke JobVacancy
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    // Relasi ke Position (jika ada model terpisah)
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
