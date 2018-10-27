<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\RasController;

Route::get('/login', function (Request $request) {
  return view('login');
})->name('login');
Route::post('/login', [ 'uses' => 'LoginController@doLogin' ]);
Route::get('/logout', [ 'uses' => 'LoginController@logOut' ]);

Route::get('/', function () {
  return view('home');
})->middleware('auth');

Route::resource('/hasil-lab', 'THasilLabController')->middleware('auth');
Route::resource('/pasien', 'PasienController')->middleware('auth');
Route::resource('/pemilik', 'PemilikController')->middleware('auth');

// Start of Ras routes
Route::resource('/ras', 'RasController')->middleware('auth');
Route::get('ras/{id}/del', 'RasController@destroy')->middleware('auth');
// End of Ras routes

// Start of TipePenKhusus routes
Route::resource('/pen-khusus', 'PenKhususController')->middleware('auth');
// End of TipePenKhusus routes

// Start of JenisHewan routes
Route::resource('/ras', 'RasController')->middleware('auth');
Route::resource('/jenis-hewan', 'JHController')->middleware('auth');
Route::get('/jenis-hewan/{id}/del', 'JHController@destroy')->middleware('auth');
// End of JenisHewan routes


// Rekam Medik routes
Route::get('/rekam-medik', 'RekMedikController@index')->middleware('auth');
Route::get('/rekam-medik/{id}/edit', 'RekMedikController@edit')->middleware('auth');
Route::get('/rekam-medik/{id}/delete', 'RekMedikController@destroy')->middleware('auth');
Route::get('/rekam-medik/new/iden', function () {
  $jenis_hewan_list = \App\JenisHewan::all();
  $pen_types = \App\TipePenKhusus::all();

  $jhras_list = \App\JHRas::with('jenis_hewan')->with('ras')->get()->map(function ($item) {
    return [
      'id' => $item->id,
      'ras' => $item->ras->nama,
      'jenis_hewan' => $item->jenis_hewan->id
    ];
  });

  return view('rek-medik.create-new', [
    'jenis_hewan_list' => $jenis_hewan_list,
    'jhras_list' => $jhras_list,
    'pen_types' => $pen_types
  ]);
})->middleware('auth');

Route::get('/rekam-medik/old/iden', function () {
  $jenis_hewan_list = \App\JenisHewan::all();

  $jhras_list = \App\JHRas::with('jenis_hewan')->with('ras')->get()->map(function ($item) {
    return [
      'id' => $item->id,
      'ras' => $item->ras->nama,
      'jenis_hewan' => $item->jenis_hewan->id
    ];
  });

  $pen_types = \App\TipePenKhusus::all();

  return view('rek-medik.create-old', [
    'jenis_hewan_list' => $jenis_hewan_list,
    'jhras_list' => $jhras_list,
    'pen_types' => $pen_types
  ]);
})->middleware('auth');