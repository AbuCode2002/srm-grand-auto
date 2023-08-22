<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                  ->nullable()
            ;
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
            ;
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('company_id')
                  ->nullable()
            ;
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
            ;
            $table->timestamp('created_at')
                  ->nullable()
            ;
            $table->timestamp('updated_at')
                  ->nullable()
            ;
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
        Schema::dropIfExists('clients');
    }
}
