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
    Schema::create('states', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedInteger('country_id');
      $table->string('country_code');
      $table->string('fips_code')->nullable();
      $table->string('iso2')->nullable();
      $table->string('type')->nullable();
      $table->decimal('latitude', 10, 8)->nullable();
      $table->decimal('longitude', 11, 8)->nullable();
      $table->boolean('flag')->default(1);
      $table->string('wikiDataId')->nullable()->comment('Rapid API GeoDB Cities');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('states');
  }
};
