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
    Schema::create('vacations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id')->constrained('staff');
      $table->foreignId('vacation_type_id')->constrained();
      $table->date('start_date');
      $table->date('end_date');
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
    Schema::dropIfExists('vacations');
  }
};
