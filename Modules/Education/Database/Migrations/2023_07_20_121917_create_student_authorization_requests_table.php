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
    Schema::create('student_authorization_requests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('subscription_id')->constrained();
      $table->foreignId('unity_id')->constrained();
      $table->foreignId('authorized_by')->nullable()->constrained('users');
      $table->boolean('exempted')->default(false);
      $table->text('content')->nullable();
      $table->date('authorization_date')->nullable();
      $table->string('file')->nullable();
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
    Schema::dropIfExists('student_authorization_requests');
  }
};
