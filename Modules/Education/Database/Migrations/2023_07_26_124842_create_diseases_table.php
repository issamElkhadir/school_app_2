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
    Schema::create('diseases', function (Blueprint $table) {
      $table->id();
      $table->foreignId('school_id')->constrained('schools');
      $table->string('name');
      $table->string('description')->nullable();
      $table->string('symptoms');
      $table->string('treatment');
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
    Schema::dropIfExists('diseases');
  }
};
