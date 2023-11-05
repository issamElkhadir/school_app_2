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
    Schema::create('form_questions', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('type');
      $table->text('description')->nullable();
      $table->foreignId('section_id')->constrained('form_sections');
      $table->boolean('is_required')->default(false);
      $table->integer('order');
      $table->integer('points')->nullable();
      $table->json('options')->nullable();
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
    Schema::dropIfExists('form_questions');
  }
};
