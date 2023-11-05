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
        Schema::create('pack_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pack_id')->constrained();
            $table->foreignId('article_id')->constrained();
            $table->foreignId('currency_id')->constrained('currencies');
            $table->float('sale_price')->default(0);
            $table->float('discount')->default(0);
            $table->float('vat')->default(0);
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
        Schema::dropIfExists('pack_articles');
    }
};
