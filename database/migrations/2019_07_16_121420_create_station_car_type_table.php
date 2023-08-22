<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationCarTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_car_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('created_at')
                  ->nullable()
            ;
            $table->timestamp('updated_at')
                  ->nullable()
            ;
            $table->unsignedBigInteger('station_id')
                  ->nullable()
            ;
            $table->foreign('station_id')
                  ->references('id')
                  ->on('stations')
            ;
            $table->unsignedBigInteger('car_type_id')
                  ->nullable()
            ;
            $table->foreign('car_type_id')
                  ->references('id')
                  ->on('car_types')
            ;
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('station_car_type');
    }
}
