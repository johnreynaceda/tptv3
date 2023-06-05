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
        Schema::create('survey_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('question_one');
            $table->integer('question_two');
            $table->integer('question_three');
            $table->integer('question_four');
            $table->integer('question_five');
            $table->integer('question_six');
            $table->integer('question_seven');
            $table->integer('question_eight');
            $table->integer('question_nine');
            $table->integer('question_ten');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('survey_results');
    }
};
