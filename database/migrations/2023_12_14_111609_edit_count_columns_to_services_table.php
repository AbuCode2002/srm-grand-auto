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

        Schema::table('services', function (Blueprint $table) {
            $table->unsignedDouble('count')->nullable()->change();
            $table->string('unit')->nullable()->change();
            $table->unsignedDouble('price')->nullable()->change();
            $table->unsignedDouble('sale_percent')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('count')->change();
            $table->string('unit')->change();
            $table->unsignedDouble('price')->change();
            $table->unsignedDouble('sale_percent')->change();
        });
    }
};
