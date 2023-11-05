<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('measure_units', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->foreignId('measure_unit_category_id')->constrained();
      $table->boolean('active')->default(true);
      $table->float('ratio');
      $table->string('type');
      $table->trackingColumns();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('measure_units');
  }
};
