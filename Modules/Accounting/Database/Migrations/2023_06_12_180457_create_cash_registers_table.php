<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_registers', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('rtl_name')->nullable();
          $table->boolean('status')->default(false);
          $table->boolean('is_real')->default(true);
          $table->float('initial_balance')->default(0);
          $table->morphs('owner');
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
        Schema::dropIfExists('cash_registers');
    }
};
