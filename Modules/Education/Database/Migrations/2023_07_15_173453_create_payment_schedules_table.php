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
    Schema::create('payment_schedules', function (Blueprint $table) {
      $table->id();
      $table->double('amount_to_pay');
      $table->double('amount_paid')->default(0);
      $table->date('payment_date');
      $table->foreignId('payment_bill_id')->constrained();
      $table->unsignedBigInteger('invoicing_policy');
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
    Schema::dropIfExists('payment_schedules');
  }
};
