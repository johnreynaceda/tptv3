<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examination_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('examinee_number')->nullable();
            $table->string('math_raw_score')->nullable();
            $table->string('math_standard_score')->nullable();
            $table->string('english_raw_score')->nullable();
            $table->string('english_standard_score')->nullable();
            $table->string('filipino_raw_score')->nullable();
            $table->string('filipino_standard_score')->nullable();
            $table->string('science_raw_score')->nullable();
            $table->string('science_standard_score')->nullable();
            $table->string('social_studies_raw_score')->nullable();
            $table->string('social_studies_standard_score')->nullable();
            $table->string('total_raw_score')->nullable();
            $table->string('total_standard_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
};
