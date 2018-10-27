<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class THasilLabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result = \App\TipeHasilLab::all()->map(function ($it) {
          $struk = json_decode($it->struktur);
          return [
            'id' => $it->id,
            'nama' => $it->nama,
            'n_attribut' => count($struk),
            'struktur' => $struk
          ];
        });
        return view('hasil-lab.index', [
          'items' => $result
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
        return view('hasil-lab.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama = $request->input('nama');
        $items = $request->input('items');
        $th_lab = new \App\TipeHasilLab();
        $th_lab->nama = $nama;
        $th_lab->struktur = json_encode($items);
        $th_lab->save();
        
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
        $it = \App\TipeHasilLab::find($id);
        $struk = json_decode($it->struktur);
        $item = [
          'id' => $it->id,
          'nama' => $it->nama,
          'n_attribut' => count($struk),
          'struktur' => $struk
        ];
        // return json_encode($struk);
        return view('hasil-lab.edit', [
          'item' => $item
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
        $nama = $request->input('nama');
        $items = $request->input('items');
        
        $thl = \App\TipeHasilLab::find($id);
        $thl->nama = $nama;
        $thl->struktur = json_encode($items);

        $thl->save();
        return redirect('/hasil-lab');
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
    }

    public function api_getAll() {
      $result = \App\TipeHasilLab::all()->map(function ($it) {
        $struk = json_decode($it->struktur);
        return [
          'id' => $it->id,
          'nama' => $it->nama,
          'struktur' => $struk
        ];
      });
      return response()->json($result);
    }
}
