<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('region_id');
            $table->string('address');
            $table->text('fact_address')
                  ->nullable()
            ;
            $table->string('jur_address')
                  ->nullable()
            ;
            $table->string('bin');
            $table->string('bik');
            $table->string('iik');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->timestamp('created_at')
                  ->nullable()
            ;
            $table->timestamp('updated_at')
                  ->nullable()
            ;
            $table->softDeletes();

            $table->foreign('region_id')
                  ->references('id')
                  ->on('regions')
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
        Schema::dropIfExists('stations');
    }
}
