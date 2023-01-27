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
        Schema::create('school_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('school_graduated')->nullable();
            $table->string('year_graduated')->nullable();
            $table->string('school_last_attended')->nullable();
            $table->string('year_last_attended')->nullable();
            $table->string('previous_school_address')->nullable();
            $table->string('track_and_strand_taken')->nullable();
            $table->string('honor_or_awards_received')->nullable();
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
        Schema::dropIfExists('school_information');
    }
};
