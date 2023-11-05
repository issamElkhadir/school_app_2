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
    Schema::create('medical_forms', function (Blueprint $table) {
      $table->id();
      $table->foreignId('school_id')->constrained('schools');
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->string('short_name')->nullable();
      $table->text('description')->nullable();
      $table->boolean('status')->default(false);
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
    Schema::dropIfExists('medical_forms');
  }
};
