<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone');
            $table->string('name');
            $table->unsignedBigInteger('company_id')
                  ->nullable()
            ;
            $table->timestamp('created_at')
                  ->nullable()
            ;
            $table->timestamp('updated_at')
                  ->nullable()
            ;
            $table->softDeletes();

            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
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
        Schema::dropIfExists('drivers');
    }
}
