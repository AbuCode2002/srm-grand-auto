<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                  ->nullable()
            ;
            $table->unsignedBigInteger('shop_id')
                  ->nullable()
            ;
            $table->timestamps();


            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
            ;
            $table->foreign('shop_id')
                  ->references('id')
                  ->on('shops')
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
        Schema::dropIfExists('shop_managers');
    }
}
