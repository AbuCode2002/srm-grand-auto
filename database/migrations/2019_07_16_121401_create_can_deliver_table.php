<?php

use Illuminate\Database\Migrations\Migration;

class CreateCanDeliverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('can_deliver', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->timestamp('delivery_time')->nullable();
        //     $table->timestamp('created_at')->nullable();
        //     $table->timestamp('updated_at')->nullable();
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
        // Schema::dropIfExists('can_deliver');
    }
}
