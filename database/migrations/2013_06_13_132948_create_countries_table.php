<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('iso3')->nullable();
          $table->string('numeric_code')->nullable();
          $table->string('iso2')->nullable();
          $table->string('phone_code')->nullable();
          $table->string('capital')->nullable();
          $table->string('currency')->nullable();
          $table->string('currency_name')->nullable();
          $table->string('currency_symbol')->nullable();
          $table->string('tld')->nullable();
          $table->string('native')->nullable();
          $table->string('region')->nullable();
          $table->string('subregion')->nullable();
          $table->text('timezones')->nullable();
          $table->text('translations')->nullable();
          $table->decimal('latitude', 10, 8)->nullable();
          $table->decimal('longitude', 11, 8)->nullable();
          $table->string('emoji')->nullable();
          $table->string('emojiU')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
