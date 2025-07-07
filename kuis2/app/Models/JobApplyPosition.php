<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplyPosition extends Model
{
    use HasFactory;

    protected $table = 'job_apply_positions';

    protected $fillable = [
        'date',
        'society_id',
        'job_vacancy_id',
        'position_id',
        'job_apply_societies_id',
        'status'
    ];

    public function position()
    {
        return $this->belongsTo(AvailablePosition::class, 'position_id');
    }

    public function society()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    public function jobApplySociety()
    {
        return $this->belongsTo(JobApplySociety::class, 'job_apply_societies_id');
    }
}
