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
    Schema::create('payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('source_cash_register_id')->constrained('cash_registers');
      $table->bigInteger('payment_method');
      $table->foreignId('destination_cash_register_id')->constrained('cash_registers');
      $table->foreignId('staff_id')->constrained('staff');
      $table->foreignId('currency_id')->constrained('currencies');
      $table->morphs('customer');
      $table->morphs('payable');
      $table->string('memo')->nullable();
      $table->double('amount')->default(0);
      $table->date('payment_date');
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
    Schema::dropIfExists('payments');
  }
};
