<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('pre_rebate_yn')->nullable();
            $table->integer('pre_rebate_above')->nullable();
            $table->integer('pre_rebate_dollor')->nullable();
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
            $table->dropColumn('pre_rebate_yn');
            $table->dropColumn('pre_rebate_above');
            $table->dropColumn('pre_rebate_dollor');
        });
    }
}
