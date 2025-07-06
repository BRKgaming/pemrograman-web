<?php

namespace Modules\Pendaftaran\App\Models;

use Illuminate\Database\Eloquent\Model;

class Daftar extends Model
{
    protected $table = 'daftars'; // pastikan nama tabel sesuai di database

    protected $fillable = [
        'nama',
        'asal_sekolah',
        'prodi_tujuan'
    ];
}