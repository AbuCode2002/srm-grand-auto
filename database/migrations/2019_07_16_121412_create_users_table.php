<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')
                  ->unique()
            ;
            $table->timestamp('email_verified_at')
                  ->nullable()
            ;
            $table->string('password');
            $table->string('remember_token')
                  ->nullable()
            ;
            $table->unsignedBigInteger('role_id')
                  ->nullable()
            ;
            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
            ;
            // $table->unsignedBigInteger('region_id')->nullable();
            // $table->foreign('region_id')->references('id')->on('regions');
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
        Schema::dropIfExists('users');
    }
}
