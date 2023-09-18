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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('defective_act_id');
            $table->string('name');
            $table->unsignedBigInteger('count');
            $table->string('unit');
            $table->unsignedDouble('price');
            $table->unsignedDouble('sale_percent');
            $table->timestamps();

            $table->foreign('defective_act_id')
                ->references('id')
                ->on('defective_acts')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
