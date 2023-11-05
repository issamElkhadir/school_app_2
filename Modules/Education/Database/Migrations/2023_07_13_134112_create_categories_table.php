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
    Schema::create('categories', function (Blueprint $table) {
      $table->id();
      $table->foreignId('parent_category_id')->nullable()->constrained('categories');
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->string('short_name')->nullable();
      $table->string('description')->nullable();
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
    Schema::dropIfExists('categories');
  }
};
