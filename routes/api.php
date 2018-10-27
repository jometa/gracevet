<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/jenis-hewan', 'JHController@api_getAll');
Route::get('/ras', 'RasController@api_getAll');
Route::get('/hasil-lab', 'THasilLabController@api_getAll');
Route::get('/pemilik', 'PemilikController@api_getByKeyword');
Route::get('/pasien', 'PasienController@api_getByKeyword');

Route::post('/new-member-rek-medik', function (Request $request) {  
  DB::transaction(function () use ($request) {
    $pemilik_json = $request->input('pemilik');
    $pasien_json = $request->input('pasien');
    $rekam_medik_json = $request->input('rekam_medik');
    $hasil_labs_json = $request->input('hasil_labs');
    $pen_khusus_json = $request->input('pen_khusus');

    $pemilik = new \App\Pemilik();
    $pemilik->fill($pemilik_json);
    $pemilik->save();
  
    $pasien = new \App\Pasien();

    $pasien->jh_ras_id = $pasien_json['ras'];
    unset($pasien_json['jenis_hewan_id']);
    unset($pasien_json['ras']);    
    $pasien->fill($pasien_json);
    $pasien->save();
  
    $rekam_medik = new \App\RekamMedik();
    $rekam_medik->fill($rekam_medik_json);
    $rekam_medik->pasien_id = $pasien->id;
    $rekam_medik->pemilik_id = $pemilik->id;
    $rekam_medik->save();
  
    // Create hasil lab
    foreach ($hasil_labs_json as $hl_json) {
      $hasil_lab = new \App\HasilLab();
      $hasil_lab->items = json_encode($hl_json['struktur']);
      $hasil_lab->tipe_id = $hl_json['id'];
      $hasil_lab->rekam_medik_id = $rekam_medik->id;
      $hasil_lab->save();
    }

    foreach ($pen_khusus_json as $pk_json) {
      $rekam_medik->pen_khusus()->attach($pk_json['id']);
      $rekam_medik->save();
      $rekam_medik->pen_khusus()->updateExistingPivot($pk_json['id'], [ 'deskripsi' => $pk_json['deskripsi'] ]);
      $rekam_medik->save();

      // Increment usage of pk
      $pk_2 = \App\TipePenKhusus::find($pk_json['id']);
      $pk_2->penggunaan += 1;
      $pk_2->save();
    }
  });

  return 'OK';
});

Route::post('/old-member-rek-medik', function (Request $request) {  
  DB::transaction(function () use ($request) {
    $pemilik_id = $request->input('pemilik');
    $pasien_id = $request->input('pasien');
    $rekam_medik_json = $request->input('rekam_medik');
    $hasil_labs_json = $request->input('hasil_labs');
    $pen_khusus_json = $request->input('pen_khusus');

    $pemilik = \App\Pemilik::find($pemilik_id);
    $pasien = \App\Pasien::find($pasien_id);
  
    $rekam_medik = new \App\RekamMedik();
    $rekam_medik->fill($rekam_medik_json);
    $rekam_medik->pasien_id = $pasien->id;
    $rekam_medik->pemilik_id = $pemilik->id;
    $rekam_medik->save();
  
    // Create hasil lab
    foreach ($hasil_labs_json as $hl_json) {
      $hasil_lab = new \App\HasilLab();
      $hasil_lab->items = json_encode($hl_json['struktur']);
      $hasil_lab->tipe_id = $hl_json['id'];
      $hasil_lab->rekam_medik_id = $rekam_medik->id;
      $hasil_lab->save();
    }

    foreach ($pen_khusus_json as $pk_json) {
      $rekam_medik->pen_khusus()->attach($pk_json['id']);
      $rekam_medik->save();
      $rekam_medik->pen_khusus()->updateExistingPivot($pk_json['id'], [ 'deskripsi' => $pk_json['deskripsi'] ]);
      $rekam_medik->save();

      // Increment usage of pk
      $pk_2 = \App\TipePenKhusus::find($pk_json['id']);
      $pk_2->penggunaan += 1;
      $pk_2->save();
    }
  });
  return 'OK';
});

Route::post('/rek-medik/update', function (Request $request) {
  DB::transaction(function () use ($request) {
    $pemilik_id = $request->input('pemilik');
    $pasien_id = $request->input('pasien');
    $rekam_medik_json = $request->input('rekam_medik');
    $hasil_labs_json = $request->input('hasil_labs');
    $pen_khusus_json = $request->input('pen_khusus');
  
    $id = $rekam_medik_json['id'];
    unset($rekam_medik_json['id']);
    \App\RekamMedik::find($id)->delete();
  
    $rekam_medik = new \App\RekamMedik();
    $rekam_medik->fill($rekam_medik_json);
    $rekam_medik->pasien_id = $pasien_id;
    $rekam_medik->pemilik_id = $pemilik_id;
    $rekam_medik->save();
  
    // Create hasil lab
    foreach ($hasil_labs_json as $hl_json) {
      $hasil_lab = new \App\HasilLab();
      $hasil_lab->items = json_encode($hl_json['struktur']);
      $hasil_lab->tipe_id = $hl_json['id'];
      $hasil_lab->rekam_medik_id = $rekam_medik->id;
      $hasil_lab->save();
    }
  
    foreach ($pen_khusus_json as $pk_json) {
      $rekam_medik->pen_khusus()->attach($pk_json['id']);
      $rekam_medik->save();
      $rekam_medik->pen_khusus()->updateExistingPivot($pk_json['id'], [ 'deskripsi' => $pk_json['deskripsi'] ]);
      $rekam_medik->save();

      // It was decremented when we remove RekamMedik
      $pk_2 = \App\TipePenKhusus::find($pk_json['id']);
      $pk_2->penggunaan += 1;
      $pk_2->save();
    }
  });
}); 

Route::get('/count/pemilik', function (Request $request) {
  return response()->json([
    'value' => \App\Pemilik::count()
  ]);
});
Route::get('/count/pasien', function (Request $request) {
  return response()->json([
    'value' => \App\Pasien::count()
  ]);
});
Route::get('/count/kunjungan', function (Request $request) {
  return response()->json([
    'value' => \App\RekamMedik::count()
  ]);
});
Route::get('/count/jenis-hewan', function (Request $request) {
  return response()->json([
    'value' => \App\JenisHewan::count()
  ]);
});
Route::get('/plot/kunjungan', function (Request $request) {
  $result = DB::table('time_dimension')
    ->leftJoin('rekam_mediks', 'time_dimension.db_date', '=', 'rekam_mediks.tanggal')
    ->select('time_dimension.db_date as tanggal', DB::raw('COUNT(rekam_mediks.id) as total'))
    ->where([
      ['time_dimension.db_date', '<', DB::raw('DATE(NOW())')],
      ['time_dimension.weekend_flag', '=', 'f']
    ])
    ->groupBy('time_dimension.db_date')
    ->orderBy('time_dimension.db_date', 'desc')
    ->limit(30)
    ->get();
  return response()->json($result);
});

function countKunjunganScoped ($filterScope) {
  array_push($filterScope, [
    'time_dimension.weekend_flag', '=', 'f'
  ]);
  return DB::table('time_dimension')
      ->leftJoin('rekam_mediks', 'time_dimension.db_date', '=', 'rekam_mediks.tanggal')
      ->select('time_dimension.db_date as tanggal', DB::raw('COUNT(rekam_mediks.id) as total'))
      ->where($filterScope)
      ->groupBy('time_dimension.db_date')
      ->orderBy('time_dimension.db_date', 'desc')
      ->get()->map(function ($x) { return $x->total; })->sum();
}

function CurrentQuarter(){
  $n = date('n');
  if($n < 4){
       return 1;
  } elseif($n > 3 && $n <7){
       return 2;
  } elseif($n >6 && $n < 10){
       return 3;
  } elseif($n >9){
       return 4;
  }
}

Route::post('/count/quarter/kunjungan', function (Request $request) {
  $year = date('Y');
  $quarter = CurrentQuarter();
  if ($request->input('year') != null) {
    $year = $request->input('year');
  }
  if ($request->input('quarter') != null) {
    $quarter = $request->input('quarter');
  }

  return response()->json([
    'value' => countKunjunganScoped([
      ['time_dimension.year', '=', $year],
      ['time_dimension.quarter', '=', $quarter]
    ])
  ]);
});

Route::post('/count/month/kunjungan', function (Request $request) {
  $year = date('Y');
  $month = date('m');
  if ($request->input('year') != null) {
    $year = $request->input('year');
  }
  if ($request->input('month') != null) {
    $month = $request->input('month');
  }

  return response()->json([
    'value' => countKunjunganScoped([
      ['time_dimension.year', '=', $year],
      ['time_dimension.month', '=', $month]
    ])
  ]);
});

Route::post('/count/week/kunjungan', function (Request $request) {
  $year = date('Y');
  $week = date('W');
  if ($request->input('year') != null) {
    $year = $request->input('year');
  }
  if ($request->input('week') != null) {
    $week = $request->input('week');
  }

  return response()->json([
    'value' => countKunjunganScoped([
      ['time_dimension.year', '=', $year],
      ['time_dimension.week', '=', $week]
    ])
  ]);
});

Route::post('/count/day/kunjungan', function (Request $request) {
  $year = date('Y');
  $month = date('m');
  $day = date('d');
  if ($request->input('year') != null) {
    $year = $request->input('year');
  }
  if ($request->input('month') != null) {
    $month = $request->input('month');
  }
  if ($request->input('day') != null) {
    $day = $request->input('day');
  }

  return response()->json([
    'value' => countKunjunganScoped([
      ['time_dimension.year', '=', $year],
      ['time_dimension.month', '=', $month],
      ['time_dimension.day', '=', $day]
    ])
  ]);
});

Route::get('/last/{count}/kunjungan', function ($count) {
  $items = \App\RekamMedik::with('pemilik')
          ->with('pasien')
          ->where('tanggal', '<=', date('Y-m-d'))->limit($count)->get();
  return response()->json([ 'items' => $items ]);
});