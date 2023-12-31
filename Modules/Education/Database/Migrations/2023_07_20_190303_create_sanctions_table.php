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
    Schema::create('sanctions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_id')->constrained('staff');
      $table->date('date');
      $table->string('reason')->nullable();
      $table->text('description')->nullable();
      $table->string('decision')->nullable();
      $table->foreignId('sanction_type_id')->constrained();
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
    Schema::dropIfExists('sanctions');
  }
};
