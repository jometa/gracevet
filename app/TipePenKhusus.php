<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipePenKhusus extends Model
{
    //
    public function rekam_mediks () {
      return $this->belongsToMany('App\RekamMedik', 'rm_pen_khusus', 'pk_id', 'rm_id');
    }
}
