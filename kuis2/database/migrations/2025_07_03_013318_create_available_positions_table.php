<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('available_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_vacancy_id');
            $table->string('position')->nullable();
            $table->bigInteger('capacity')->default(1);
            $table->bigInteger('apply_capacity')->default(1);
            $table->timestamps();

            $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_positions');
    }
};
