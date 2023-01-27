<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('slot_id');
            $table->string('time');
            $table->integer('room_number');
            $table->integer('seat_number')->default(0);
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
        Schema::dropIfExists('student_slots');
    }
};
