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
    Schema::create('periods', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->boolean('status')->nullable();
      $table->timestamp('start_date');
      $table->timestamp('end_date');
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
    Schema::dropIfExists('periods');
  }
};
