<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schools', function (Blueprint $table) {
      $table->id();

      // General Information
      $table->string('name');
      $table->string('rtl_name')->nullable();
      $table->string('short_name')->nullable();
      $table->boolean('active')->default(true);

      // Contact Information
      $table->contactColumns();

      // School Information
      $table->date('authorization_date')->nullable();
      $table->string('authorization_number')->nullable();
        $table->string('authorization_information')->nullable();
      $table->string('rtl_authorization_information')->nullable();
      $table->string('cnss')->nullable();
      $table->string('rc')->nullable();
      $table->string('ice')->nullable();
      $table->string('establishment_type')->nullable();
      $table->string('responsible_name')->nullable();
      $table->string('responsible_phone_number')->nullable();
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
    Schema::dropIfExists('schools');
  }
};
