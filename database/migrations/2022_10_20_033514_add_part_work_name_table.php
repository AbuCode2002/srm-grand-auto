<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defect_act_part', function (Blueprint $table) {
            $table->string('part_name')
                  ->nullable()
            ;
        });
        Schema::table('defect_act_work', function (Blueprint $table) {
            $table->string('work_name')
                  ->nullable()
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defect_act_part', function (Blueprint $table) {
            //
        });
    }
};
