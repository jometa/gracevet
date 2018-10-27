<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisitInfosJhRas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('j_h_ras', function (Blueprint $table) {
            //
            $table->integer('total_visit')->unsigned()->default(0);
            $table->datetime('last_visit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('J_h_ras', function (Blueprint $table) {
            //
        });
    }
}
