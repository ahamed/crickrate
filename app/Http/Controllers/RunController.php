<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batsman;
use Illuminate\Support\Facades\Input;
use App\Over;
use App\Player;
use App\Bowlerrecord;
use App\Batsmenrecord;
use App\Bowler;
use App\Commentary;

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


    

    public function addRun(Request $request,$mid,$inngs){
        $isOver = false;
        $batsman = new Batsman;
        $over = new Over;
        $striker = $batsman->where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get()->first();
        $inactive = $batsman->where('match_id',$mid)->where('innings',$inngs)->where('onStrike',0)->where('isActive',1)->get()->first();
        
        /*
            * Evaluate the over data
            * This records go to overs table
        */

        $overs = $over -> where('match_id',$mid)->where('innings',$inngs)->where('overflag',1)->get()->first();
        $currentBowler  = Bowler::where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get()->first();


        $bowlers = Bowlerrecord::where('cap',$currentBowler->cap)->get()->first();
        $batsmanrecords = Batsmenrecord::where('cap',$striker->cap)->get()->first();
        //return $batsmanrecords;
        $commentary = new Commentary;
        $overnumber = Bowler::where('match_id',$mid)->where('innings',$inngs)->get()->sum('over');
        $ballnumber = Bowler::where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get()->first()->ball;
        $ballnumber +=1;
        if($ballnumber>=6){
            $overnumber +=1;
            $ballnumber = 0;
        }
        $totalOver = $overnumber.'.'.$ballnumber;


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



            if(Input::get('extra') || Input::get('lb')){

            }else{

                //generate commentary here
                //addCommentary($run);
                //generate commentary here
                $commentary->match_id = $mid;
                $commentary->innings = $inngs;
                $commentary->over = $totalOver;
                $commentary->run = $run;
                $commentary->commentary = $bowlers->player. ' to '. $striker->name;
                $commentary->save();



                //calculate the point of a batsman get
                $pp = $run * (1/36);
                $bonus = map($bowlers->value * $run,0,60,0,(1/36));
                $FR = $pp + $bonus;
                $striker->rating += $FR;
                $striker->save();


                // Calculate the rating point for bowlers
                $pp = (3-$run) * (1/36);
                $bouns = map($batsmanrecords->value * (3-$run), 0, 30, 0, (1/36));
                $FR = $pp + $bouns;
                $currentBowler->rating += $FR;
                $currentBowler->save();

            }



        if(Input::get('extra') == 'wide'){
            $overs->bowlerextra += 1;
            $overs->overextra += $run;
            $overs->runs += $run+1;
            $overs->thisover .= 'wd+'.$run.',';
            $overs->save();

            //generate commentary here
            //addCommentary('wd+'.$run);
            //generate commentary here
                $commentary->match_id = $mid;
                $commentary->innings = $inngs;
                $commentary->over = $totalOver;
                $commentary->run = 'wd+'+$run;
                $commentary->commentary = $bowlers->player. ' to '. $striker->name;
                $commentary->save();
            
            $currentBowler->run += $run + 1;
            $currentBowler->extra += $run + 1;
            if($run == 4){
                $currentBowler->fours += 1;
            }elseif($run == 6){
                $currentBowler->sixs += 1;
            }
            $currentBowler->economy = $currentBowler->run / (float)($currentBowler->over.".".$currentBowler->ball);
            $currentBowler->save();


        }elseif(Input::get('extra') == 'noball'){
            /*
                * check if the run comes from by or legby or from bat
                * if By or legby then batsman don't get any run on his
                * account. Else he get
            */

            if(Input::get('lb') == 'lb'){
                $overs->runs += $run + 1;   //
                $overs->bowlerextra += 1;
                $overs->overextra += $run;
                $overs->thisover .= 'nb+'.$run.'l/b,';
                $overs->save();


                //generate commentary here
               // addCommentary('nb+'.$run.'l/b');
                //generate commentary here
                $commentary->match_id = $mid;
                $commentary->innings = $inngs;
                $commentary->over = $totalOver;
                $commentary->run = 'nb+'.$run.'l/b';
                $commentary->commentary = $bowlers->player. ' to '. $striker->name;
                $commentary->save();


                // add bowler sate here
                $currentBowler->run += 1;
                $currentBowler->extra += $run+1;
                $currentBowler->economy = $currentBowler->run / (float)($currentBowler->over.".".$currentBowler->ball);
                $currentBowler->save();

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

                //generate commentary here
               //addCommentary('nb+'.$run);
                //generate commentary here
                $commentary->match_id = $mid;
                $commentary->innings = $inngs;
                $commentary->over = $totalOver;
                $commentary->run = 'nb+'+$run;
                $commentary->commentary = $bowlers->player. ' to '. $striker->name;
                $commentary->save();


                $currentBowler->run += $run + 1;
                $currentBowler->extra += 1;
                if($run == 4){
                    $currentBowler->fours += 1;
                }elseif($run == 6){
                    $currentBowler->sixs += 1;
                }
                $currentBowler->economy = $currentBowler->run / (float)($currentBowler->over.".".$currentBowler->ball);
                $currentBowler->save();
                
                $overs->save();
                $striker->save();
                $inactive->save();



            }
        }else{

            /*
                * Check if the run comes from legby / by or not
            */

            if(Input::get('lb')){


                $currentBowler->extra += $run;
                $currentBowler->ball +=1;
               
                if($currentBowler->ball >= 6){
                    $currentBowler->ball = 0;
                    $currentBowler->over += 1;
                    $currentBowler->onStrike = 0;
                }
                $currentBowler->economy = $currentBowler->run / (float)($currentBowler->over.".".$currentBowler->ball);
                $currentBowler->save();


                $overs->runs += $run;
                $overs->overextra += $run;
                $overs->balls += 1;
                $overs->thisover .= ''.$run.'l/b'.',';
                $striker->ball += 1;
                $striker->onStrike = false;
                $inactive->onStrike = true;
                $srate = ($striker->run / $striker->ball)*100;
                $striker->sr = $srate;
                $striker->save();
                $inactive->save();

                //generate commentary here
                //generate commentary here
                $commentary->match_id = $mid;
                $commentary->innings = $inngs;
                $commentary->over = $totalOver;
                $commentary->run = $run;
                $commentary->commentary = $bowlers->player. ' to '. $striker->name;
                $commentary->save();

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
                    $currentBowler->onStrike = 0;
                    $currentBowler->save();
                    
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
                        $currentBowler->onStrike = 0;
                        $currentBowler->save();
                 
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
                            $currentBowler->onStrike = 0;
                            $currentBowler->save();
                     
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

                $currentBowler->run += $run;
                $currentBowler->ball +=1;
                if($run == 4){
                    $currentBowler->fours += 1;
                }elseif($run == 6){
                    $currentBowler->sixs += 1;
                }

                
                
                if($currentBowler->ball >= 6){
                    $currentBowler->ball = 0;
                    $currentBowler->over += 1;
                    $currentBowler->onStrike = 0;
                }
                $currentBowler->economy = $currentBowler->run / (float)($currentBowler->over.".".$currentBowler->ball);
                
                $currentBowler->save();

                //generate commentary here
                $commentary->match_id = $mid;
                $commentary->innings = $inngs;
                $commentary->over = $totalOver;
                $commentary->run = $run;
                $commentary->commentary = $bowlers->player. ' to '. $striker->name;
                $commentary->save();

              


                $overs->save();
                $striker->save();
                $inactive->save();

            }
        }
    }
       return redirect()->back();
      // return $pp;
      //  return $bowlers;
    }





    public function clearAll($mid,$inngs){
        Batsman::where('match_id',$mid)->where('innings',$inngs)->truncate();
        Bowler::where('match_id',$mid)->where('innings',$inngs)->truncate();
        Over::where('match_id',$mid)->where('innings',$inngs)->truncate();
        $over = new Over;
        $over->match_id = $mid;
        $over->innings = $inngs;
        $over->runs = 0;
        $over->balls = 0;
        $over->overno = 0;
        $over->overflag = 1;
        $over->bowlerextra = 0;
        $over->overextra = 0;
        $over->save();
        return redirect('/score-control');

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
