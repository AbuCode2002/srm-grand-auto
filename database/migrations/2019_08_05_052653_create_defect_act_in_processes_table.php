<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectActInProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defect_act_in_processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('defect_act_id');
            $table->unsignedBigInteger('order_id');
            $table->boolean('approved')
                  ->default(0)
            ;
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
            ;
            $table->foreign('defect_act_id')
                  ->references('id')
                  ->on('defect_acts')
            ;
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
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
        Schema::dropIfExists('defect_act_in_processes');
    }
}
