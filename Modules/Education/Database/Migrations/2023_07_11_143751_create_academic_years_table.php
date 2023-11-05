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
    Schema::create('academic_years', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->boolean('status')->nullable()->default(true);
      $table->date('start_date')->nullable();
      $table->date('end_date')->nullable();
      $table->boolean('is_locked')->default(false);
      $table->foreignId('parent_academic_year_id')->nullable()->constrained('academic_years');
      $table->string('parent_academic_year_name')->nullable();
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
    Schema::dropIfExists('academic_years');
  }
};
