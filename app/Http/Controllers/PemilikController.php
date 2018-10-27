<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $keyword = '';
        $page = 1;
        $perPage = 50;
        if ($request->query('keyword') !== null){
          $keyword = $request->query('keyword');
        }
        if ($request->query('perPage') !== null) {
          $perPage = $request->query('perPage');
        }

        $items = \App\Pemilik::where('nama', 'LIKE', '%' . $keyword . '%')
                ->paginate($perPage);
        return view('pemilik.index', [
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
        return view('pemilik.create');
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
        $nama = $request->nama;
        $alamat = $request->alamat;
        $no_telp = $request->no_telp;

        // Create new ras
        $pem = new \App\Pemilik();
        $pem->nama = $nama;
        $pem->alamat = $alamat;
        $pem->no_telp =$no_telp;

        $pem->save();
        return redirect('/pemilik');
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
        //
        $pemilik = \App\Pemilik::find($id);
        return view('pemilik.edit', [
          'item' => $pemilik
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
        $pemilik = \App\Pemilik::find($id);
        $pemilik->nama = $request->nama;
        $pemilik->no_telp = $request->no_telp;
        $pemilik->alamat = $request->alamat;
        $pemilik->save();
        return redirect('/pemilik');
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
        DB::table('pemiliks')->where('id', $id)->delete();
        return 'OK';
    }

    public function api_GetByKeyword (Request $request) {
      $keyword = $request->query('keyword');
      $result = \App\Pemilik::where('nama', 'LIKE', '%' . $keyword . '%')->get()->toJson();
      return $result;
    }
}
