<?php

use Illuminate\Database\Migrations\Migration;

class CreateOrderMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('order_media', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->timestamp('created_at')->nullable();
        //     $table->timestamp('updated_at')->nullable();
        //     $table->unsignedBigInteger('order_id')->nullable();
        //     $table->foreign('order_id')->references('id')->on('orders');
        //     $table->unsignedBigInteger('media_id')->nullable();
        //     $table->foreign('media_id')->references('id')->on('media');
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('order_media');
    }
}
