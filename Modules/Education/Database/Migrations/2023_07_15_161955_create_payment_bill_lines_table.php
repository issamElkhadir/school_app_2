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
        Schema::create('payment_bill_lines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->morphs('item');
            $table->foreignId('payment_bill_id')->constrained();
            $table->foreignId('unit_id')->constrained('measure_units');
            $table->double('price_unit');
            $table->float('quantity');
            $table->float('vat');
            $table->double('subtotal');
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
        Schema::dropIfExists('payment_bill_lines');
    }
};
