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
  public function up()
  {
    Schema::create('contract_types', function (Blueprint $table) {
      $table->id();
      $table->foreignId('school_id')->constrained('schools');
      $table->string('name');
      $table->string('rtl_name');
      $table->string('short_name');
      $table->string('description')->nullable();
      $table->boolean('status');
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
    Schema::dropIfExists('contract_types');
  }
};
