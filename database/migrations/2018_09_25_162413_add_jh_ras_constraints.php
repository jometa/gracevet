<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJhRasConstraints extends Migration
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
            $table->integer('jenis_hewan_id')->unsigned();
            $table->foreign('jenis_hewan_id')->references('id')->on('jenis_hewans');
            $table->integer('ras_id')->unsigned();
            $table->foreign('ras_id')->references('id')->on('ras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('j_h_ras', function (Blueprint $table) {
            //
            $table->dropForeign(['jenis_hewan_id', 'ras_id']);
        });
    }
}
