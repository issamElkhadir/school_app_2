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
    Schema::create('articles', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->string('product_type')->default('service');
      $table->unsignedBigInteger('invoicing_policy');
      $table->foreignId('currency_id')->constrained('currencies');
      $table->foreignId('category_id')->constrained();
      $table->foreignId('unit_id')->constrained('measure_units');
      $table->float('sale_price')->default(0);
      $table->float('vat')->default(0);
      $table->string('default_code')->nullable();
      $table->string('barcode')->nullable();
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
    Schema::dropIfExists('articles');
  }
};
