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
    Schema::create('schedules', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->date('start_date')->nullable();
      $table->foreignId('class_id')->constrained('classes');
      $table->foreignId('level_id')->constrained();
      $table->foreignId('branch_id')->constrained();
      $table->boolean('active')->default(false);
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
    Schema::dropIfExists('schedules');
  }
};
