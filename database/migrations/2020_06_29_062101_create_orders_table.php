<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->float('record');
            $table->float('total');
            $table->integer('user_id');
            $table->string('status');
            $table->string('pre_cashback_yn')->nullable();
            $table->string('pre_levelname')->nullable();
            $table->integer('pre_above')->nullable();
            $table->float('pre_percent')->nullable();
            $table->float('pre_dollor')->nullable();
            $table->string('receiver');
            $table->string('receiver_address');
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
        Schema::dropIfExists('orders');
    }
}
