<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusVisibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_visibilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('status_id');
            $table->boolean('is_visible');
            $table->timestamps();

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
            ;
            $table->foreign('status_id')
                  ->references('id')
                  ->on('statuses')
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
        Schema::dropIfExists('status_visibilities');
    }
}
