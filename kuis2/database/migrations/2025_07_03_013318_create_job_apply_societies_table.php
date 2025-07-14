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
        Schema::create('job_apply_societies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('notes')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('society_id');
            $table->unsignedBigInteger('job_vacancy_id')->nullable();
            $table->timestamps();

            $table->foreign('society_id')->references('id')->on('societies');
            $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_apply_societies');
    }
};
