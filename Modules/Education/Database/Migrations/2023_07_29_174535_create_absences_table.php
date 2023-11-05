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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absence_type_id')->constrained('absence_types');
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('achievement_id')->constrained('achievements');
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->text('note')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('absences');
    }
};
