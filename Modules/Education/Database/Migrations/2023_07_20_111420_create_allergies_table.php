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
        Schema::create('allergies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('allergy_type_id')->constrained('allergy_types');
            $table->string('name');
            $table->string('rtl_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('description')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('allergies');
    }
};
