<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekMedikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $perPage = $request->query('perPage');
  
        if ($startDate == null || $startDate == ''){
          $startDate = date('Y-m-d', strtotime('today - 100 days'));
        }
        if ($endDate == null || $endDate == ''){
          $endDate = date('Y-m-d');
        }
        if ($perPage == null || $perPage == '') {
          $perPage = 50;
        }
  
        $items = \App\RekamMedik::whereBetween('tanggal', [$startDate, $endDate])
          ->paginate($perPage);
        return view('rek-medik.index', [
          'items' => $items,
          'perPage' => $perPage,
          'startDate' => $startDate,
          'endDate' => $endDate
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
        return view('rek-medik.create-new');
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
        $rek_medis = \App\RekamMedik::find($id);

        // Decode hasil lab struktur
        $hasil_labs = $rek_medis->hasil_labs->map(function ($it) {
          $tipe = \App\TipeHasilLab::find($it->tipe_id);
          return [
            'id' => $it->id,
            'nama' => $tipe->nama,
            'struktur' => json_decode($it->items)
          ];
        });
        return view('rek-medik.edit', [
          'item' => $rek_medis,
          'hasil_labs' => $hasil_labs,
          'pen_types' => $rek_medis->pen_khusus()->get()
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
        \App\RekamMedik::find($id)->delete();
        return redirect('/rekam-medik');
    }
}
