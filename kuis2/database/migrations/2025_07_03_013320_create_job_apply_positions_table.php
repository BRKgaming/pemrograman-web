<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_apply_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('society_id');
            $table->unsignedBigInteger('job_vacancy_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('job_apply_societies_id')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('society_id')->references('id')->on('societies');
            $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies');
            $table->foreign('position_id')->references('id')->on('available_positions');
            $table->foreign('job_apply_societies_id')->references('id')->on('job_apply_societies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_apply_positions');
    }
};
