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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('schedule_id')->constrained();
            $table->foreignId('classroom_id')->constrained();
            $table->foreignId('staff_id')->constrained('staff');
            $table->foreignId('subject_id')->constrained();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('day');
            $table->string('content')->nullable();
            $table->trackingColumns();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};
