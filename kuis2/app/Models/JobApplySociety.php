<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplySociety extends Model
{
    use HasFactory;

    protected $table = 'job_apply_societies';

    protected $fillable = [
        'notes',
        'date',
        'society_id',
        'job_vacancy_id'
    ];

    // Relationship to Society
    public function society()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }

    // Relationship to JobVacancy
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    // Relationship to JobApplyPositions (through pivot)
    public function positions()
    {
        return $this->hasMany(JobApplyPosition::class, 'job_apply_societies_id');
    }
}