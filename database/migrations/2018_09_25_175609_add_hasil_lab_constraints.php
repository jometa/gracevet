<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasilLabConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hasil_labs', function (Blueprint $table) {
            //
            $table->foreign('rekam_medik_id')->references('id')->on('rekam_mediks')->onDelete('cascade');
            $table->foreign('tipe_id')->references('id')->on('tipe_hasil_labs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hasil_labs', function (Blueprint $table) {
            //
        });
    }
}
