<?php
namespace Modules\Application\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model {
    protected $fillable = [
        'society_id', 'job_vacancy_id', 'position_id',
        'notes', 'status'
    ];

    // Relasi ke Society (pengguna)
    public function society() {
        return $this->belongsTo(\App\Models\Society::class);
    }
}

