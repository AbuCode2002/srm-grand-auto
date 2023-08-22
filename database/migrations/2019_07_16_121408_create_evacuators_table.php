<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvacuatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evacuators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->unsignedBigInteger('region_id');
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
        Schema::dropIfExists('evacuators');
    }
}
