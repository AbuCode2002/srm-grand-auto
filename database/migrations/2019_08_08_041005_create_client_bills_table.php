<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('defect_act_id');
            $table->float('overal_price');
            $table->string('bill_id');
            $table->timestamp('paid_at')
                  ->nullable()
            ;
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('defect_act_id')
                  ->references('id')
                  ->on('defect_acts')
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
        Schema::dropIfExists('client_bills');
    }
}
