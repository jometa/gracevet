<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilLab extends Model
{
    //
    public function hasilLab() {
      return $this->belongsTo('App\RekamMedik');
    }
}
