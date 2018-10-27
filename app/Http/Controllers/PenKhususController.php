<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipePenKhusus;

class PenKhususController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = TipePenKhusus::all();
        return view('pen-khusus.index', [
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
        return view('pen-khusus.create');
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
        $it = new TipePenKhusus();
        $it->nama = $request->input('nama');
        $it->save();
        return redirect('/pen-khusus');
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
        $it = TipePenKhusus::find($id);
        return view('pen-khusus.edit', [
          'item' => $it
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
        $it = TipePenKhusus::find($id);
        $it->nama = $request->input('nama');
        $it->save();
        return redirect('/pen-khusus');
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
        TipePenKhusus::find($id)->delete();
        return redirect('/pen-khusus');
    }
}
