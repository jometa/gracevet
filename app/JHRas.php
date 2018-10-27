<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JHRas extends Model
{
    //
    public function jenis_hewan() {
      return $this->belongsTo('App\JenisHewan', 'jenis_hewan_id');
    }

    public function ras() {
      return $this->belongsTo('App\Ras', 'ras_id');
    }

    public function rekam_mediks () {
      return $this->hasMany('App\Pasien', 'jh_ras_id');
    }
}
