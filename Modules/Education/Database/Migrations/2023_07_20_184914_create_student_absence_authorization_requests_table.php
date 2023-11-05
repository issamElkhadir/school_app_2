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
    Schema::create('student_absence_authorization_requests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('subscription_id')->constrained();
      $table->foreignId('accepted_by')->nullable()->constrained('users');
      $table->dateTimeTz('start_date');
      $table->dateTimeTz('end_date');
      $table->boolean('accepted')->default(false);
      $table->text('content')->nullable();
      $table->string('file')->nullable();
      $table->date('authorization_date')->nullable();
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
    Schema::dropIfExists('student_absence_authorization_requests');
  }
};
