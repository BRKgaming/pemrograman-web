<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) { // yang berarti menyuruh untuk membuatkan tabel 'mahasiswas' di DB, sesuai isi kolom dibawah ini, yang mana Laravel secara otomatis menambahkan‘s’.
            $table->id(); // seting id biarkan seperti ini karena otomatis AI
            $table->string('nama'); //tipe string membuat varchar(255)
            $table->string('nim')->unique(); // dibuat unik di DB
            $table->string('prodi');
            $table->date('tanggal_lahir'); // tipe date untuk tanggal lahir
            $table->string('alamat')->nullable(); // nullable jika tidak diisi
            $table->timestamps(); // waktu saat pengisian
        });
    }

     
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
