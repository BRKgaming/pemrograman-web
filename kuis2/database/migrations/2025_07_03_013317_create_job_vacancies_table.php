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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_category_id');
            $table->string('company');
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('job_category_id')->references('id')->on('job_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
