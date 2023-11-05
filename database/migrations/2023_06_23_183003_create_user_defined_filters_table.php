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
    Schema::create('user_defined_filters', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('qualified_model_name');
      $table->string('model');
      $table->json('filters');
      $table->text('description')->nullable();
      $table->boolean('is_default')->default(false);
      $table->boolean('is_enabled')->default(true);
      $table->foreignId('user_id')->constrained();
      $table->trackingColumns();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_defined_filters');
  }
};
