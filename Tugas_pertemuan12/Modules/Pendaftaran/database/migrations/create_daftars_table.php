<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
public function up()
{


 Schema::create('daftars', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('asal_sekolah');
                $table->string('prodi_tujuan');
                $table->timestamps();
        });

}
public function down()
{
Schema::dropIfExists('daftars');//jika sudah ada dan akan adapembaruan maka akan ditimpa migration yang baru.

}
};