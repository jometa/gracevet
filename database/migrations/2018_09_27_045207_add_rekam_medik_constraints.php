<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRekamMedikConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekam_mediks', function (Blueprint $table) {
            //
            $table->foreign('pasien_id')
              ->references('id')
              ->on('pasiens');
            $table->foreign('pemilik_id')
              ->references('id')
              ->on('pemiliks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekam_mediks', function (Blueprint $table) {
            //
        });
    }
}
