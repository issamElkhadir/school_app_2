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
    Schema::create('guardians', function (Blueprint $table) {
      $table->id();
      $table->string('first_name', 240);
      $table->string('last_name', 240);
      $table->string('rtl_first_name', 240)->nullable();
      $table->string('rtl_last_name', 240)->nullable();
      $table->string('cni_number', 45);
      $table->string('home_phone', 45)->nullable();
      $table->string('mobile_phone', 45)->nullable();
      $table->string('email_address', 240)->nullable();
      $table->foreignId('country_id')->constrained('countries');
      $table->foreignId('city_id')->nullable()->constrained('cities');
      $table->string('gender');
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
    Schema::dropIfExists('guardians');
  }
};
