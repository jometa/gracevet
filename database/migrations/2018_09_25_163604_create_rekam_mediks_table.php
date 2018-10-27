<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekamMediksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_mediks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pasien_id')->unsigned();
            $table->integer('pemilik_id')->unsigned();
            $table->dateTime('tanggal');
            $table->double('berat', 10, 5)->default(1.0);
            $table->enum('tipe_norek', ['GA', 'GB', 'GC', 'GD']);
            $table->double('freq_n', 10, 5)->default(1.0);
            $table->double('freq_p', 10, 5)->default(1.0);
            $table->integer('freq_t')->unsigned()->default(1);
            $table->string('mth')->nullable();
            $table->string('mulut')->nullable();
            $table->string('kul_rambut')->nullable();
            $table->string('kelenjar_limfe')->nullable();
            $table->string('pernapasan')->nullable();
            $table->string('peredaran_darah')->nullable();
            $table->string('pencernaan')->nullable();
            $table->string('kelamin_perkencingan')->nullable();
            $table->string('ang_gerak')->nullable();
            $table->string('diagnosa')->nullable();
            $table->string('prognosis')->nullable();
            $table->string('terapi')->nullable();
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
        Schema::dropIfExists('rekam_mediks');
    }
}
