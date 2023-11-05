<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('mail_servers', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedBigInteger('priority');
      $table->boolean('active')->default(true);
      $table->string('username');
      $table->text('password');
      $table->string('smtp_host');
      $table->string('smtp_port');
      $table->string('smtp_encryption')->nullable();
      $table->trackingColumns();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('mail_servers');
  }
};
