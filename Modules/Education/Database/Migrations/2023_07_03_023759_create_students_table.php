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
    Schema::create('students', function (Blueprint $table) {
      $table->id();
      $table->string('first_name');
      $table->string('last_name');
      $table->text('image')->nullable();
      $table->string('rtl_first_name')->nullable();
      $table->string('rtl_last_name')->nullable();
      $table->string('gender')->nullable();
      $table->foreignId('nationality_id')->constrained('countries');
      $table->foreignId('birth_city_id')->constrained('cities');

      $table->contactColumns();

      $table->string('cin')->nullable();
      $table->string('cne')->nullable();
      $table->date('birthday')->nullable();
      $table->foreignId('native_language')->nullable()->constrained('languages');
      $table->foreignId('second_language')->nullable()->constrained('languages');

      $table->string('quotation')->nullable();
      $table->string('insurance_name')->nullable();
      $table->string('insurance_number')->nullable();
      $table->string('old_school')->nullable();
      $table->string('old_academy')->nullable();
      $table->string('old_delegation')->nullable();
      $table->text('notes')->nullable();
      $table->text('how_he_knew_the_school')->nullable();
      $table->boolean('has_scholarship')->default(false);
      $table->string('scholarship_holder')->nullable();

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
    Schema::dropIfExists('students');
  }
};
