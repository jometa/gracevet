<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JHRas;
use App\JenisHewan;
use App\Ras;

class RasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = JHRas::with('jenis_hewan')->with('ras')->get();
        return view('ras.index', [
          'items' => $items
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
        $jenis_hewan_list = JenisHewan::all();
        return view('ras.create', [
          'jenis_hewan_list' => $jenis_hewan_list
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
        $jh_id = $request->jenis_hewan;
        $nama = $request->nama;

        // Create new ras
        $ras = new Ras();
        $ras->nama = $nama;

        $ras->save();
        $jh = JenisHewan::find($jh_id);
        $jh_ras = new JHRas();
        $jh_ras->jenis_hewan_id = $jh_id;
        $jh_ras->ras_id = $ras->id;
        $jh_ras->save();
        return redirect('/ras');
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
      $it = JHRas::with('jenis_hewan')->with('ras')->find($id);
      $list = JenisHewan::all();
      $item = [
        'id' => $it->id,
        'ras' => $it->ras->nama,
        'ras_id' => $it->ras->id,
        'jenis_hewan_id' => $it->jenis_hewan->id
      ];
      return view('ras.edit', [
        'item' => $item,
        'jenis_hewan_list' => $list
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
        $ras = Ras::find($request->ras_id);
        $ras->nama = $request->nama;
        $ras->save();
        return redirect('/ras');
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
        $it = JHRas::find($id)->first();
        $it->delete();
        return redirect('/ras');
    }

    public function api_getAll() {
      $result = JHRas::with('jenis_hewan')->with('ras')->get()->map(function ($item) {
        return [
          'id' => $item->id,
          'ras' => $item->ras->nama,
          'jenis_hewan' => $item->jenis_hewan->nama,
          'total_visit' => $item->total_visit,
          'last_visit' => $item->last_visit
        ];
      });
      return response()->json($result);
    }
}
