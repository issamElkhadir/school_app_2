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
    Schema::create('packs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('level_id')->constrained('levels');
      $table->string('name');
      $table->unsignedBigInteger('invoicing_policy');
      $table->string('rtl_name')->nullable();
      $table->double('sale_price')->nullable();
      $table->foreignId('unit_id')->constrained('measure_units');
      $table->string('short_name')->nullable();
      $table->string('description')->nullable();
      $table->boolean('status')->default(false);
      $table->float('vat')->default(0);
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
    Schema::dropIfExists('packs');
  }
};
