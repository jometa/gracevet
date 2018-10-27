<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $it = \App\JenisHewan::all();
        return view('jenis-hewan.index', [
          'items' => $it
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
        return view('jenis-hewan.create');
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
        $jh = new \App\JenisHewan();
        $jh->nama = $request->nama;
        $jh->save();
        return redirect('/jenis-hewan');
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
        $jh = \App\JenisHewan::find($id);
        return view('jenis-hewan.edit', [
          'item' => $jh
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
        $jh = \App\JenisHewan::find($id);
        $jh->nama = $request->nama;
        $jh->save();
        return redirect('/jenis-hewan');
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
        \App\JenisHewan::find($id)->delete();
        return redirect('/');
    }

    public function api_getAll() {
      $result = \App\JenisHewan::all();
      return response()->json($result);
    }
}
