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
            $table->unsignedBigInteger('client_id');

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

            $table->boolean('is_evacuated');
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
            $table->integer('status_internal')
                  ->nullable()
            ;
            $table->timestamp('ready_to_repair_at')
                  ->nullable()
            ;
            $table->timestamp('diagnosed_at')
                  ->nullable()
            ;
            $table->unsignedBigInteger('contract_id')
                  ->nullable()
            ;
            $table->unsignedBigInteger('station_id')
                  ->nullable()
            ;
            $table->unsignedBigInteger('transportation_id')
                  ->nullable()
            ;
            $table->foreign('station_id')
                  ->references('id')
                  ->on('stations')
            ;
            $table->timestamp('completed_at')
                  ->nullable()
            ;
            $table->unsignedBigInteger('evacuator_id')
                  ->nullable()
            ;
            $table->foreign('evacuator_id')
                  ->references('id')
                  ->on('evacuators')
            ;
            $table->timestamp('created_at')
                  ->nullable()
            ;
            $table->timestamp('updated_at')
                  ->nullable()
            ;
            $table->timestamp('ready_to_diagnose_at')
                  ->nullable()
            ;
            $table->timestamp('planned_to_completed_at')
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
            // $table->foreign('status')->references('id')->on('statuses');
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
            ;
            $table->foreign('driver_id')
                  ->references('id')
                  ->on('drivers')
            ;
            $table->foreign('contract_id')
                  ->references('id')
                  ->on('contracts')
            ;
            // $table->foreign('transportation_id')->references('id')->on('transportations');
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
