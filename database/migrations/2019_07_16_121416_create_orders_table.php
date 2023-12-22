<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('car_id');

            $table->string('service_type')
                  ->nullable()
            ;
            $table->string('driver_type')
                  ->nullable()
            ;
            $table->integer('mileage')
                  ->nullable()
            ;
            $table->boolean('is_broken')
                  ->nullable()
            ;
            $table->unsignedBigInteger('region_id');
            $table->string('actual_location')
                  ->nullable()
            ;
            $table->unsignedBigInteger('driver_id')
                  ->nullable()
            ;
            $table->string('problem_description');
            $table->integer('status')
                  ->nullable()
            ;
            $table->unsignedBigInteger('contract_id')
                  ->nullable()
            ;
            $table->unsignedBigInteger('station_id')
                  ->nullable()
            ;
            $table->foreign('station_id')
                  ->references('id')
                  ->on('stations')
            ;
            $table->timestamp('created_at')
                  ->nullable()
            ;
            $table->timestamp('updated_at')
                  ->nullable()
            ;
            $table->softDeletes();

            $table->foreign('car_id')
                  ->references('id')
                  ->on('cars')
            ;
            $table->foreign('region_id')
                  ->references('id')
                  ->on('regions')
            ;
            $table->foreign('driver_id')
                  ->references('id')
                  ->on('drivers')
            ;
            $table->foreign('contract_id')
                  ->references('id')
                  ->on('contracts')
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
        Schema::dropIfExists('orders');
    }
}
