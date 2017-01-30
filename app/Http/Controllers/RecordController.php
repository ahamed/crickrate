<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batsmenrecord;

class RecordController extends Controller
{

  


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($coun)
    {
        $states = Batsmenrecord::where('country',$coun)->orderBy('value','DESC')->get();
        return view('display.batsman-record',compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('data.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record  = new Batsmenrecord;
        $record->player = $request->player;
        $record->Gavg = $request->Gavg;
        $record->Gsr = $request->Gsr;
        $record->LTavg = $request->Lavg;
        $record->LTsr = $request->Lsr;
        $indexG = $request->Gavg * $request->Gsr;
        $indexLT = $request->Lavg * $request->Lsr;

        $mappedIndexG = map($indexG,0,60000,0,10);
        $mappedIndexLT = map($indexLT,0,60000,0,10);
        $value = ($mappedIndexG+$mappedIndexLT)/2;
        $record->value = $value;
        $record->country = $request->country;
        $record->save();
        return redirect()->back();
        //return $value;
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
    }
}
