<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $keyword = $request->query('keyword');
      $perPage = $request->query('perPage');

      if ($keyword == null){
        $keyword = '';
      }
      if ($perPage == null || $perPage == '') {
        $perPage = 50;
      }

      $items = \App\Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
              ->paginate($perPage);
      return view('pasien.index', [
        'items' => $items,
        'perPage' => $perPage,
        'keyword' => $keyword
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $jenis_hewan_list = \App\JenisHewan::all();
        
        $jhras_list = \App\JHRas::with('jenis_hewan')->with('ras')->get()->map(function ($item) {
          return [
            'id' => $item->id,
            'ras' => $item->ras->nama,
            'jenis_hewan' => $item->jenis_hewan->id
          ];
        });
      
        return view('pasien.create', [
          'jenis_hewan_list' => $jenis_hewan_list,
          'jhras_list' => $jhras_list
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $pasien = new \App\Pasien();
        $pasien->nama = $request->nama;
        $pasien->jk = $request->jk;
        $pasien->signalemen = $request->signalemen;
        $pasien->lahir = $request->lahir;
        $pasien->jh_ras_id = $request->jh_ras_id;
        $pasien->save();
        return redirect('/pasien');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pasien = \App\Pasien::find($id);
        $jenis_hewan_list = \App\JenisHewan::all();
        
        $jhras_list = \App\JHRas::with('jenis_hewan')->with('ras')->get()->map(function ($item) {
          return [
            'id' => $item->id,
            'ras' => $item->ras->nama,
            'jenis_hewan' => $item->jenis_hewan->id
          ];
        });
      
        return view('pasien.edit', [
          'jenis_hewan_list' => $jenis_hewan_list,
          'jhras_list' => $jhras_list,
          'item' => $pasien
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $pasien = \App\Pasien::find($id);
        $pasien->nama = $request->nama;
        $pasien->jk = $request->jk;
        $pasien->signalemen = $request->signalemen;
        $pasien->lahir = $request->lahir;
        $pasien->jh_ras_id = $request->jh_ras_id;
        $pasien->save();
        return redirect('/pasien');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pasien = \App\Pasien::find($id);
        $pasien->delete();
        return redirect('/pasien');
    }

    public function api_GetByKeyword (Request $request) {
      $keyword = $request->query('keyword');
      $result = \App\Pasien::with('jhRas.jenis_hewan', 'jhRas.ras')
        ->where('nama', 'LIKE', '%' . $keyword . '%')->get()->toJson();
      return $result;
    }
}
