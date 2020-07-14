<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDollorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dollor_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('tx_type')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('sub_total');
            $table->string('order_id')->nullable();
            $table->string('memo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dollor_logs');
    }
}
