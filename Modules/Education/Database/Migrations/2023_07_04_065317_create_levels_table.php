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
    Schema::create('levels', function (Blueprint $table) {
      $table->id();
      $table->foreignId('branch_id')->constrained('branches');
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->string('short_name')->nullable();
      $table->boolean('status')->default(false);
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
    Schema::dropIfExists('levels');
  }
};
