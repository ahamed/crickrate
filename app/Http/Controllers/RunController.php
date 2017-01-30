<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batsman;
use Illuminate\Support\Facades\Input;
use App\Over;

class RunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        return view('control-panel.cpanel',compact('thisovers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        
    }

    public function addRun(Request $request){
        $isOver = false;
        $batsman = new Batsman;
        $over = new Over;
        $striker = $batsman->where('onStrike',1)->get()->first();
        $inactive = $batsman->where('onStrike',0)->where('isActive',1)->get()->first();
        
        /*
            * Evaluate the over data
            * This records go to overs table
        */

        $overs = $over -> where('match_id',1)->where('innings','1st')->where('overflag',1)->get()->first();
        // At the above line we assume the match_id is 1 and this is first innings
        //N.B. This line must be changed later.




  /*
        *   add bowler cap number 
        *   at overs table
        */

        if(Input::get('addBowler')){
            if($overs->balls == 0){
                $overs->cap = $request->bowlername;
                $overs->save();
            }
        }else{


            // Find the run per ball

             $run = 0;

            if(Input::get('zero')){
                $run = 0;
            }elseif(Input::get('one')){
                $run = 1;
            }elseif(Input::get('two')){
                $run = 2;
            }elseif(Input::get('three')){
                $run = 3;
            }elseif(Input::get('four')){
                $run = 4;
            }elseif(Input::get('five')){
                $run = 5;
            }elseif(Input::get('six')){
                $run = 6;
            }




        if(Input::get('extra') == 'wide'){
            $overs->bowlerextra += 1;
            $overs->overextra += $run;
            $overs->runs += $run+1;
            $overs->thisover .= 'wd+'.$run.',';
            $overs->save();
        }elseif(Input::get('extra') == 'noball'){
            /*
                * check if the run comes from by or legby or from bat
                * if By or legby then batsman don't get any run on his
                * account. Else he get
            */

            if(Input::get('lb') == 'lb'){
                $overs->runs += $run + 1;
                $overs->bowlerextra += 1;
                $overs->overextra += $run;
                $overs->thisover .= 'nb+'.$run.',';
                $overs->save();
            }else{
                //Check if the run is even then add the run and the strike is not rotate.
       
                if($run % 2 == 0){
                $striker->run += $run;
                if($run == 4){
                    $striker->fours += 1;
                }elseif($run == 6){
                    $striker->sixs +=1;
                }
                $striker->ball += 1;
                $srate = ($striker->run / $striker->ball)*100;
                $striker->sr = $srate;


                }else{
                    $striker->run += $run;
                    $striker->onStrike = false;
                    $inactive->onStrike = true;
                    $striker->ball += 1;
                    $srate = ($striker->run / $striker->ball)*100;
                    $striker->sr = $srate;
                }

                $overs->runs += $run + 1;
                $overs->bowlerextra += 1;
                $overs->overextra += $run;
                $overs->thisover .= 'nb+'.$run.',';
                
                $overs->save();
                $striker->save();
                $inactive->save();



            }
        }else{

            /*
                * Check if the run comes from legby / by or not
            */

            if(Input::get('lb')){
                $overs->runs += $run;
                $overs->overextra += $run;
                $overs->balls += 1;
                $overs->thisover .= ''.$run.'l/b'.',';
                

                if($overs->balls >= 6){
                    $overs->balls = 0;

                    $isOver = true;
                    $overs->overflag = 0;
                    $striker->onStrike = false;
                    $inactive->onStrike = true;
                    $striker->save();
                    $inactive->save();
                    $newovers = $overs->replicate();
                    $newovers->runs = 0;
                    $newovers->thisover = "";
                    $newovers->overflag = 1;
                    $newovers->overextra = 0;
                    $newovers->bowlerextra = 0;
                    $newovers->save();
                    
                }
                $overs->save();

            }else{

                if($run % 2 == 0){

                    $striker->run += $run;
                    if($run == 4){
                        $striker->fours += 1;
                    }elseif($run == 6){
                        $striker->sixs +=1;
                    }
                    $striker->ball += 1;
                    $srate = ($striker->run / $striker->ball)*100;
                    $striker->sr = $srate;

                    $overs->runs += $run;
                    $overs->balls += 1;
                    $overs->thisover .= ''.$run.',';
                
                    if($overs->balls >= 6){
                        $overs->balls = 0;
                        $striker->onStrike = false;
                        $inactive->onStrike = true;
                        $striker->save();
                        $inactive->save();
                        $overs->overflag = 0;
                        $newovers = $overs->replicate();
                        $newovers->runs = 0;
                        $newovers->thisover = "";
                        $newovers->overflag = 1;
                        $newovers->overextra = 0;
                        $newovers->bowlerextra = 0;
                        $newovers->save();
                 
                    }
                }else{

                      $overs->runs += $run;
                        $overs->balls += 1;
                        $overs->thisover .= ''.$run.',';
                    
                        if($overs->balls >= 6){
                            $overs->balls = 0;
                            
                            $overs->overflag = 0;
                            $newovers = $overs->replicate();
                            $newovers->runs = 0;
                            $newovers->thisover = "";
                            $newovers->overflag = 1;
                            $newovers->overextra = 0;
                            $newovers->bowlerextra = 0;
                            $newovers->save();
                     
                        }else{
                            $striker->onStrike = false;
                            $inactive->onStrike = true;
                            $striker->save();
                            $inactive->save();
                        }



                    $striker->run += $run;
                    $striker->ball += 1;
                    $srate = ($striker->run / $striker->ball)*100;
                    $striker->sr = $srate;

                
                }




              


                $overs->save();
                $striker->save();
                $inactive->save();

            }
        }
    }
        return redirect()->back();
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
