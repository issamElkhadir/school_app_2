<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('classes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('class_id')->nullable()->constrained();
      $table->foreignId('school_id')->constrained('schools');
      $table->foreignId('level_id')->constrained();
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->boolean('status')->default(true);
      $table->trackingColumns();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::dropIfExists('classes');
  }
};
