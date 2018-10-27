<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRmPenKhusus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rm_pen_khusus', function (Blueprint $table) {
            $table->increments('id');
            $table->text('deskripsi')->nullable();
            $table->integer('rm_id')->unsigned();
            $table->integer('pk_id')->unsigned();
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
        Schema::dropIfExists('rm_pen_khusus');
    }
}
