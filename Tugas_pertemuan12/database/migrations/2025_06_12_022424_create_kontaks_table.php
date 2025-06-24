<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
public function up()
{
Schema::create('kontaks', function (Blueprint $table) {// yangberarti menyuruh untuk membuatkan tabel kontaks di DB, sesuai isi kolom dibawah ini.


$table->id(); // seting id biarkan seperti ini karena otomatis AI
$table->string('nama'); //tipe string membuat varchar(255)
$table->text('alamat'); // tipe data text membuat text
$table->bigInteger('no_hp')->length(13);// tipe data int max 13
$table->string('email')->nullable(); // tipe data string untuk email, nullable artinya boleh kosong
$table->date('tanggal_lahir')->nullable(); // tipe data date untuk tanggal lahir, nullable artinya boleh kosong
$table->timestamps();// waktu saat pengisian
});
}
public function down()
{
Schema::dropIfExists('kontaks');//jika sudah ada dan akan adapembaruan maka akan ditimpa migration yang baru.

}
};