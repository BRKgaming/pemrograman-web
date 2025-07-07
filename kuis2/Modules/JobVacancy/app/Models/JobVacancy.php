<?php
namespace Modules\JobVacancy\Models;

use App\Models\AvailablePosition;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model {
    protected $fillable = ['job_category_id', 'company', 'address', 'description'];

    // Relasi ke Available Positions
    public function availablePositions() {
        return $this->hasMany(AvailablePosition::class);
    }
}
