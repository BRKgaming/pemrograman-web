<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailablePosition extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'available_positions';

    /**
     * The attributes that are mass assignable.
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
     * Relationship with JobVacancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    /**
     * Relationship with JobApplyPositions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobApplyPositions()
    {
        return $this->hasMany(JobApplyPosition::class, 'position_id');
    }

    /**
     * Get remaining available slots
     *
     * @return int
     */
    public function getRemainingSlotsAttribute()
    {
        return $this->capacity - $this->apply_capacity;
    }

    /**
     * Check if position is full
     *
     * @return bool
     */
    public function getIsFullAttribute()
    {
        return $this->apply_capacity >= $this->capacity;
    }
}
