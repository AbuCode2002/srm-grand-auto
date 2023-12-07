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
            $table->dropColumn('name');
            $table->unsignedBigInteger('service_name_id');
            $table->foreign('service_name_id')
                ->references('id')
                ->on('service_names');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign('services_service_name_id_foreign');
            $table->dropColumn('service_name_id');
            $table->string('name');
        });
    }
};
