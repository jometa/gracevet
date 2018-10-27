<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RekamMedik extends Model
{
    //
    protected $guarded = ['id'];

    public function pemilik () {
      return $this->belongsTo('App\Pemilik');
    }

    public function pasien () {
      return $this->belongsTo('App\Pasien');
    }

    public function hasil_labs () {
      return $this->hasMany('App\HasilLab');
    }

    public function pen_khusus () {
      return $this->belongsToMany('App\TipePenKhusus', 'rm_pen_khusus', 'pk_id', 'rm_id')
              ->withPivot('deskripsi');
    }
}
