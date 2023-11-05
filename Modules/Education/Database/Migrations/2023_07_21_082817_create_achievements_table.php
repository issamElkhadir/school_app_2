<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('achievements', function (Blueprint $table) {
      $table->id();
      $table->morphs('achievable');
      $table->foreignId('class_id')->constrained('classes');
      $table->time('start_time');
      $table->time('end_time');
      $table->date('date')->nullable();
      $table->foreignId('achievement_type_id')->constrained('achievement_types');
      $table->boolean('is_realised')->default(true);
      $table->time('delay_time')->default('00:00:00');
      $table->text('note')->nullable();
      $table->foreignId('school_id')->constrained('schools');
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
    Schema::dropIfExists('achievements');
  }
};
