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
    Schema::create('cycles', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->string('short_name');
      $table->boolean('status')->nullable();
      $table->string('description')->nullable();
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
    Schema::dropIfExists('cycles');
  }
};
