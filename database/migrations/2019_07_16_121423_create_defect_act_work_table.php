<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectActWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defect_act_work', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount');
            $table->timestamp('applied_at')
                  ->nullable()
            ;
            $table->integer('price');
            $table->timestamp('price_changed_at')
                  ->nullable()
            ;
            $table->timestamp('rejected_at')
                  ->nullable()
            ;
            $table->unsignedInteger('price_with_markup')
                  ->nullable()
            ;
            $table->timestamp('price_with_markup_updated_at')
                  ->nullable()
            ;
            $table->unsignedBigInteger('defect_act_id')
                  ->nullable()
            ;
            $table->foreign('defect_act_id')
                  ->references('id')
                  ->on('defect_acts')
            ;
            $table->unsignedBigInteger('work_id')
                  ->nullable()
            ;
            $table->foreign('work_id')
                  ->references('id')
                  ->on('works')
            ;
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
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
        Schema::dropIfExists('defect_act_work');
    }
}
