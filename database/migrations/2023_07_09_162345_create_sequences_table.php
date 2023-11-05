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
    Schema::create('sequences', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->foreignId('school_id')->constrained();
      $table->string('code');
      $table->string('prefix')->nullable();
      $table->string('suffix')->nullable();
      $table->string('length')->default(5)->nullable();
      $table->string('next_value')->default(1)->nullable();
      $table->integer('step')->default(1)->nullable();
      $table->integer('start_value')->default(1)->nullable();
      $table->integer('end_value')->nullable();
      $table->trackingColumns();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sequences');
  }
};
