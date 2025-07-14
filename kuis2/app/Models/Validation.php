<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    protected $fillable = [
        'job_category_id', 'society_id', 'validator_id',
        'status', 'work_experience', 'job_position',
        'reason_accepted', 'validator_notes'
    ];

    // Relasi ke Society
    public function society() {
        return $this->belongsTo(\App\Models\Society::class);
    }

    // Tambahkan relasi ke JobCategory
    public function jobCategory() {
        return $this->belongsTo(\App\Models\JobCategory::class, 'job_category_id');
    }

    // Relasi ke Validator (jika diperlukan)
    public function validator() {
        return $this->belongsTo(\App\Models\Validator::class, 'validator_id');
    }
}
