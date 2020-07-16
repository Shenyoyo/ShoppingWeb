<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidToOrdersTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('pre_discount_yn')->nullable();
            $table->integer('pre_discount_above')->nullable();
            $table->float('pre_discount_percent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('pre_discount_yn');
            $table->dropColumn('pre_discount_above');
            $table->dropColumn('pre_discount_percent');
        });
    }
}
