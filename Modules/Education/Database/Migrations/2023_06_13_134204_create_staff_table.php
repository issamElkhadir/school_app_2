<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('staff', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('phone')->nullable();
      $table->string('email')->nullable();
      $table->text('address')->nullable();
      $table->double('salary')->nullable();
      $table->float('week_hours')->nullable();
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
    Schema::dropIfExists('staff');
  }
};
