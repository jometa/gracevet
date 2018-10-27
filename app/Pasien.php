<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    //
    protected $guarded = ['id'];
    
    public function jhRas() {
      return $this->belongsTo('App\JHRas', 'jh_ras_id');
    }
}
