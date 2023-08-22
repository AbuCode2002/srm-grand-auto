<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->string('dir_name');
            $table->string('dir_phone');
            $table->string('specialist_name');
            $table->string('specialist_phone');
            $table->string('jur_address');
            $table->text('fact_address');
            $table->string('bin');
            $table->string('bik');
            $table->string('iik');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->unsignedBigInteger('region_id');

            $table->foreign('region_id')
                  ->references('id')
                  ->on('regions');

            $table->timestamps();
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
        Schema::dropIfExists('shops');
    }
}
