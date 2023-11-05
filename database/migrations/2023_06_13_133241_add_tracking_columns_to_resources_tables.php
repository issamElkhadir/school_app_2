<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  private $tables = ['countries', 'states', 'cities', 'currencies'];

  /**
   * Run the migrations.
   */
  public function up(): void
  {
    foreach ($this->tables as $table) {
      Schema::table($table, function (Blueprint $table) {
        $table->trackingColumns();
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    foreach ($this->tables as $table) {
      Schema::table($table, function (Blueprint $table) {
        $table->dropTrackingColumns();
      });
    }
  }
};
