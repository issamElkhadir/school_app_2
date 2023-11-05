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
    Schema::create('unities', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->string("rtl_name")->nullable();
      $table->string("short_name")->nullable();
      $table->boolean("status")->default(false);
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
    Schema::dropIfExists('unities');
  }
};
