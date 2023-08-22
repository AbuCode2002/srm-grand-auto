<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('jur_address');
            $table->text('fact_address');
            $table->string('bin');
            $table->string('bik');
            $table->string('iik');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->unsignedBigInteger('manager_id')
                  ->nullable()
            ;
            $table->unsignedBigInteger('region_id')
                  ->nullable()
            ;
            $table->foreign('region_id')
                  ->references('id')
                  ->on('regions')
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
        Schema::dropIfExists('companies');
    }
}
