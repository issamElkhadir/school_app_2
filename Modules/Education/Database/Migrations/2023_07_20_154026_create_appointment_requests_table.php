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
    Schema::create('appointment_requests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('school_id')->constrained('schools');
      $table->foreignId('staff_id')->nullable()->constrained('staff');
      $table->foreignId('student_id')->nullable()->constrained('students');
      $table->foreignId('guardian_id')->nullable()->constrained('guardians');
      $table->string('title');
      $table->text('content')->nullable();
      $table->boolean('accepted')->default(false);
      $table->text('response')->nullable();
      $table->timestamp('appointment_date')->nullable();
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
    Schema::dropIfExists('appointment_requests');
  }
};
