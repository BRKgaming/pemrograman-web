<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'regionals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'province',
        'district'
    ];

    /**
     * Relationship with Society
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function societies()
    {
        return $this->hasMany(Society::class, 'regional_id');
    }
}

