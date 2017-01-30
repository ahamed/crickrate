<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bowlerrecord;

class BowlerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('data.bowler');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bowler  = new Bowlerrecord;
        $bowler->player = $request->player;
        $bowler->Gavg = $request->Gavg;
        $bowler->Gecono = $request->Gecono;
        $bowler->LTavg = $request->Lavg;
        $bowler->LTecono = $request->Lecono;
        $indexG = (100 - $request->Gavg) * (100 - $request->Gecono);
        $indexLT = (100 - $request->Lavg) * (100 - $request->Lecono);


        // Check if the bowler has bowling average more than 100 or not? if more than 100 then he is not a valueable bowler.

        if( $request->Gavg > 100){    
            $indexG = 0;
        }
        


        // If the bowling average of last ten match is more than 100 then he is a on a bad form . So added zero for his last tem match rating. 
        
        if( $request->Lavg > 100){
            $indexLT = 0;
        }

        $mappedIndexG = map($indexG,0,60000,0,10);
        $mappedIndexLT = map($indexLT,0,60000,0,10);
        $value = ($mappedIndexG+$mappedIndexLT)/2;
        $bowler->value = $value;
        $bowler->country = $request->country;
        $bowler->save();
        return redirect()->back();
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
