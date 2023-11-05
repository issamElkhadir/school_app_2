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
    Schema::create('staff_authorization_requests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id')->constrained('staff');
      $table->foreignId('responsible_id')->nullable()->constrained('users');
      $table->date('confirmed_date')->nullable();
      $table->text('content')->nullable();
      $table->dateTime('start_date_time')->nullable();
      $table->dateTime('end_date_time')->nullable();
      $table->text('note')->nullable();
      $table->foreignId('school_id')->constrained('schools');
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
    Schema::dropIfExists('staff_authorization_requests');
  }
};
