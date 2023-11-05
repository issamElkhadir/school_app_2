<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('cities', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->foreignId('country_id')->constrained();
      $table->foreignId('state_id')->constrained();
      $table->string('country_code');
      $table->string('state_code');
      $table->decimal('latitude', 10, 8);
      $table->decimal('longitude', 11, 8);
      $table->boolean('flag')->default(true);
      $table->string('wikiDataId')->nullable()->comment('Rapid API GeoDB Cities');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cities');
  }
};
