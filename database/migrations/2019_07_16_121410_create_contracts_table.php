<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')
                  ->nullable()
            ;
            $table->string('number_of_contract');
            $table->bigInteger('budget')
                  ->default(0)
                  ->unsigned()
            ;
            $table->timestamp('signed_at')
                  ->nullable()
            ;
            $table->timestamp('expire_at')
                  ->nullable()
            ;
            $table->timestamp('enabled')
                  ->nullable()
            ;
            $table->timestamps();

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
        Schema::dropIfExists('contracts');
    }
}
