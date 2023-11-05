<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->uuid()->unique();
      $table->string('first_name');
      $table->string('middle_name')->nullable();
      $table->string('last_name');
      $table->text('address')->nullable();
      $table->string('email')->unique();
      $table->foreignId('profile_id')->nullable();
      $table->string('profile_type')->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->text("image")->nullable();
      $table->boolean('status')->default(true);
      $table->string('theme', 10)->default('light')->nullable();
      $table->rememberToken();
      $table->trackingColumns();
      $table->contactColumns();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
