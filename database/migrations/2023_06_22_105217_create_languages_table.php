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
    Schema::create('languages', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->boolean("has_translation")->default(false);
      $table->string("direction")->nullable();
      $table->string("local_code")->nullable();
      $table->string("iso_code")->nullable();
      $table->string("url_code")->nullable();
      $table->boolean("status")->nullable();
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
    Schema::dropIfExists('languages');
  }
};
