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
    Schema::create('employment_contracts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id')->constrained('staff');
      $table->date('contract_start_date')->nullable();
      $table->date('contract_end_date')->nullable();
      $table->float('net_salary')->nullable();
      $table->float('brut_salary')->nullable();
      $table->integer('nbr_days_off')->nullable();
      $table->foreignId('contract_type_id')->constrained('contract_types');
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
    Schema::dropIfExists('employment_contracts');
  }
};
