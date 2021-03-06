<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisitInfosJenisHewan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_hewans', function (Blueprint $table) {
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
        Schema::table('jenis_hewans', function (Blueprint $table) {
            //
        });
    }
}
