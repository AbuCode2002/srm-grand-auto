<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                  ->nullable()
            ;
            $table->unsignedBigInteger('station_id')
                  ->nullable()
            ;
            $table->timestamps();


            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
            ;
            $table->foreign('station_id')
                  ->references('id')
                  ->on('stations')
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
        Schema::dropIfExists('station_managers');
    }
}
