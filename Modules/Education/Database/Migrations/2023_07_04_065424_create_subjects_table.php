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
    Schema::create('subjects', function (Blueprint $table) {
      $table->id();
      $table->foreignId('unity_id')->constrained('unities');
      $table->foreignId('classroom_type_id')->constrained('classroom_types');
      $table->string("name");
      $table->string("color")->nullable();
      $table->string("massar_id");
      $table->string("order")->nullable();
      $table->text("picture")->nullable();
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
    Schema::dropIfExists('subjects');
  }
};
