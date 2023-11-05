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
    $tableNames = config('permission.table_names');

    Schema::table($tableNames['permissions'], function (Blueprint $table) use ($tableNames) {
      // Add display_name column if it does not exist
      if (!\Schema::hasColumn($tableNames['permissions'], 'display_name')) {
        $table->string('display_name')->nullable();
      }

      $table->string('model')->nullable();
      $table->string('module')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    $tableNames = config('permission.table_names');

    Schema::table($tableNames['permissions'], function (Blueprint $table) {
      $table->dropColumn('display_name');
    });
  }
};
