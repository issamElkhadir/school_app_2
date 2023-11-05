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
    Schema::create('payment_bills', function (Blueprint $table) {
      $table->id();
      $table->string('sequence');
      $table->foreignId('subscription_id')->constrained();
      $table->double('untaxed_amount');
      $table->double('tax_amount');
      $table->double('total_amount');
      $table->double('paid_amount')->default(0);
      $table->double('unpaid_amount')->default(0);
      $table->foreignId('currency_id')->constrained('currencies');
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
    Schema::dropIfExists('payment_bills');
  }
};
