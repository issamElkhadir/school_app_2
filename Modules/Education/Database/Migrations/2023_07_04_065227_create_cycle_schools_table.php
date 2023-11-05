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
        Schema::create('cycle_schools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_id')->constrained();
            $table->foreignId('school_id')->constrained('schools');
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
        Schema::dropIfExists('cycle_schools');
    }
};
