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
    Schema::create('class_subjects', function (Blueprint $table) {
      $table->id();
      $table->foreignId('class_id')->constrained('classes');
      $table->foreignId('subject_id')->constrained();

      $table->float('ects')->nullable();
      $table->float('coef')->nullable();
      $table->float('nbrh_per_week')->nullable();
      $table->float('nbr_sessions')->nullable();
      $table->integer('order')->nullable();
      $table->float('nbrh_tr')->nullable();
      $table->float('nbrh_pr')->nullable();
      $table->float('nbrh_td')->nullable();
      $table->boolean('theoretical_exam')->default(true);
      $table->boolean('practical_exam')->default(false);
      $table->boolean('regional_exam')->default(false);
      $table->boolean('has_schedule')->default(true);
      $table->boolean('has_elearning')->default(false);
      $table->boolean('has_grade_book')->default(true);
      $table->integer('nbr_exams')->nullable();
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
    Schema::dropIfExists('class_subjects');
  }
};
