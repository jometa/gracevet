<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisHewan extends Model
{
  public function jhras () {
    return $this->hasMany('App\JHRas');
  }
}
