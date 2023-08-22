<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chatroom_id');
            $table->unsignedBigInteger('user_id')
                  ->nullable()
            ;
            $table->text('message');
            $table->unsignedBigInteger('status_id')
                  ->nullable()
            ;
            $table->integer('type')
                  ->default(1)
            ;
            $table->timestamps();

            $table->foreign('chatroom_id')
                  ->references('id')
                  ->on('chatrooms')
            ;
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
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
        Schema::dropIfExists('messages');
    }
}
