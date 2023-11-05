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
    Schema::create('subject_sequences', function (Blueprint $table) {
      $table->id();
      $table->foreignId('subject_id')->constrained();
      $table->string("content")->nullable();
      $table->bigInteger("nbh")->nullable();
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
    Schema::dropIfExists('subject_sequences');
  }
};
