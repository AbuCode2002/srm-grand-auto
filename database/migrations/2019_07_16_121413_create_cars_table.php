<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('brand');
            $table->string('model');
            $table->unsignedBigInteger('company_id')
                  ->nullable();

            $table->unsignedBigInteger('contract_id')
                  ->nullable();

            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies');

            $table->foreign('contract_id')
                  ->references('id')
                  ->on('contracts');

            $table->integer('year')
                  ->nullable();

            $table->string('vin_number')
                  ->nullable();

            $table->unsignedBigInteger('type')
                  ->nullable();

            $table->foreign('type')
                  ->references('id')
                  ->on('car_types');

            $table->timestamp('created_at')
                  ->nullable();

            $table->timestamp('updated_at')
                  ->nullable();

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
        Schema::dropIfExists('cars');
    }
}
