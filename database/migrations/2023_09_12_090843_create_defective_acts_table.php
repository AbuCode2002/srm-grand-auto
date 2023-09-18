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
        Schema::create('defective_acts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedDouble('total');
            $table->unsignedDouble('markup');
            $table->unsignedDouble('total_with_markup');
            $table->unsignedDouble('sum_sale');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defective_acts');
    }
};
