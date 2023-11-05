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
    Schema::create('pre_inscriptions', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->boolean('status')->default(false);
        $table->dateTime('start_date_time');
        $table->dateTime('end_date_time');

        $table->foreignId('form_id')->constrained('forms');
        $table->foreignId('school_id')->constrained('schools');
        $table->foreignId('level_id')->constrained('levels');
        
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
    Schema::dropIfExists('pre_inscriptions');
  }
};
