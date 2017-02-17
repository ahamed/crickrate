<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Batsman;
use App\Player;
use App\Over;
use App\Bowler;
use App\Bowlerrecord;
use App\Commentary;

class AddplayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id1, $id2,$id3, $id4)
    {
        $bats = Batsman::where('match_id',$id3)->where('innings',$id4)->get();
        $totalRuns = Over::where('match_id',$id3)->where('innings',$id4)->sum('runs');
        $ind = 1;
        $records = Batsman::where('match_id',$id3)->where('innings',$id4)->where('isActive',1)->get();
        $howMany = count($records);
        $wickets = count($bats) - 2;
        $overs = Over::all();

        $time_to_select_bowler = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1)->get()->count();


        


        $bowlersRecords = Bowler::where('match_id',$id3)->where('innings',$id4)->get();
        $totalOver = Bowler::where('match_id',$id3)->where('innings',$id4)->get()->sum('over');
        $Ball = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1)->get()->first();
        $checkBall = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1);
        if($checkBall->exists()){
            $totalBall = $Ball->ball;
            $overcount = $totalOver.".".$totalBall;    
        }else{
            $totalBall = 0;
            $overcount = $totalOver.".".$totalBall;    
        }
        


         $overextra = Over::where('match_id',$id3)->where('innings',$id4)->select(\DB::raw('sum(overextra) as extra'))->groupBy('cap')->get();

         $totalOvers = Over::where('match_id',$id3)->where('innings',$id4)->select(\DB::raw('count(*) as over'))->groupBy('cap')->get();

         $bowlerName = [];

         for( $i = 0; $i < sizeof($bowlersRecords); $i++ ){

            $bowlerName[$i] = Player::where('cap',$bowlersRecords[$i]->cap)->get()->first();
         }
        



      

     

        $thisover = Over::where('match_id',$id3)->where('innings',$id4)->where('overflag',1)->get()->first();

        if(Over::where('match_id',$id3)->where('innings',$id4)->exists()){
            if($howMany >= 2){
                // $overcount = ($thisover->id-1) .'.'. $thisover->balls;
                $thisovers = explode(',',$thisover->thisover);
            }else{
                $thisovers = NULL;
                $overcount = 0;
             }    
        }else{
            $over = new Over;
            $over->match_id = $id3;
            $over->innings = $id4;
            $over->runs = 0;
            $over->balls = 0;
            $over->overflag = 1;
            $over->overextra = 0;
            $over->bowlerextra = 0;
            $over->overno = 0;
            $over->save();
            $thisovers = NULL;
        }
   



        // Retrive data from players table 
        $batsmen = Player::where('country',$id1)->get();
        $bowlers = Player::where('country',$id2)->get();

        
        return view('control-panel.cpanel',compact('bats'))->with('ind',$ind)->with('pitch',$howMany)->with('batsmen',$batsmen)->with('bowlers',$bowlers)->with('thisovers',$thisovers)->with('total_runs',$totalRuns)->with('batting',$id1)->with('bowling',$id2)->with('overcount',$overcount)->with('wickets',$wickets)->with('current_batsmen',$records)->with('bowlerNames',$bowlerName)->with('totalOver',$totalOvers)->with('all_bowlers',$bowlersRecords)->with('isTime',$time_to_select_bowler)->with('mid',$id3)->with('inngs',$id4);
        
        
      
       
    }


    public function handleOver(Request $request){



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
    public function store(Request $request,$mid,$inngs)
    {
        //add player from this function
        $batsman = new Batsman;
        $batsman->match_id = $mid;
        $batsman->innings = $inngs;
        $playerinfo = $request->playername;
        $playerinfo = explode(',', $playerinfo);
        
        $batsman->cap = $playerinfo[0];
        $batsman->name = $playerinfo[1];
        $batsman->run = 0;
        $batsman->ball = 0;
        $batsman->sr = 0.0;
        $batsman->fours = 0;
        $batsman->sixs = 0;
        $batsman->isActive = true;
        $batsman->rating = 0;
        $batsman->outStatus = "not out";
        $strike = Batsman::where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get();
        if(count($strike) < 1){
            $batsman->onStrike = true;
        }else{
            $batsman->onStrike = false;
        }

        $batsman->save();
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
    public function edit($id,$mid,$inngs)
    {


        $currentBowler  = Bowler::where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get()->first();

        $bowlers = Bowlerrecord::where('cap',$currentBowler->cap)->get()->first();
        $commentary = new Commentary;
        $overnumber = Bowler::where('match_id',$mid)->where('innings',$inngs)->get()->sum('over');
        $ballnumber = Bowler::where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get()->first()->ball;
        $ballnumber +=1;
        if($ballnumber>=6){
            $overnumber +=1;
            $ballnumber = 0;
        }
        $totalOver = $overnumber.'.'.$ballnumber;

        $over = new Over;
        $batsman = new Batsman;
        $bowler =  Bowler::where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get()->first();

        $onStriker = $batsman->where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get()->first();
        
        $inactive = $batsman->where('match_id',$mid)->where('innings',$inngs)->where('onStrike',0)->where('isActive',1)->get()->first();
        $striker = $batsman->where('match_id',$mid)->where('innings',$inngs)->where('onStrike',1)->get()->first();

        $whout = $batsman->where('match_id',$mid)->where('innings',$inngs)->where('id',$id)->get()->first();

        $runningover = $over->where('match_id',$mid)->where('innings',$inngs)->where('overflag',1)->get()->first();
        


        $outtype = "";
        $outby  = "";
        $helper = "";

        if(Input::get('out') == 'b'){
            if(Input::get('helpername') == 'no'){
                $helper = "";
            }else{
                $helper = Player::where('cap',Input::get('helpername'))->get()->first()->playername;    
            }
            $outtype = 'b';
            $outby = Player::where('cap',$bowler->cap)->get()->first()->playername;
            
        }elseif(Input::get('out') == 'c'){ 
            if($bowler->cap == Input::get('helpername')){
                $outtype = 'c & b';
                $outby = Player::where('cap',$bowler->cap)->get()->first()->playername;
            }else{
                $outtype = 'c';
                $outby = Player::where('cap',$bowler->cap)->get()->first()->playername;
                $helper = Player::where('cap',Input::get('helpername'))->get()->first()->playername;
            }
        }elseif(Input::get('out') == 'lbw'){
            if(Input::get('helpername') == 'no'){
                $helper = "";
            }else{
                $helper = Player::where('cap',Input::get('helpername'))->get()->first()->playername;    
            }
            $outtype = 'lbw';
            $outby = Player::where('cap',$bowler->cap)->get()->first()->playername;
            
        }elseif(Input::get('out') == 'st'){
            $outtype = 'st';
            $outby = Player::where('cap',$bowler->cap)->get()->first()->playername;
            $helper = Player::where('cap',Input::get('helpername'))->get()->first()->playername;
        }elseif(Input::get('out') == 'R'){
            $outtype = 'Run out';
            $outby = Player::where('cap',Input::get('helpername'))->get()->first()->playername;
            $helper = "";
        }
        
        if(Input::get('out')=='R'){
            $whout->outStatus = $outtype." (".$outby.")";

            $commentary->match_id = $mid;
            $commentary->innings = $inngs;
            $commentary->over = $totalOver;
            $commentary->run = 'Run out';
            $commentary->commentary = $bowlers->player. ' to '. $onStriker->name;
            $commentary->save();


        }elseif(Input::get('out')=='b'){
            $whout->outStatus = " b ".$outby;
            $commentary->match_id = $mid;
            $commentary->innings = $inngs;
            $commentary->over = $totalOver;
            $commentary->run = 'Out Bowleden';
            $commentary->commentary = $bowlers->player. ' to '. $onStriker->name;
            $commentary->save();
        }elseif(Input::get('out')=='lbw'){
            $whout->outStatus = $outtype." b ".$outby;
            $commentary->match_id = $mid;
            $commentary->innings = $inngs;
            $commentary->over = $totalOver;
            $commentary->run = 'Out lbw';
            $commentary->commentary = $bowlers->player. ' to '. $onStriker->name;
            $commentary->save();
        }elseif($outtype = 'c & b'){
            $whout->outStatus = $outtype." ".$outby; 
            $commentary->match_id = $mid;
            $commentary->innings = $inngs;
            $commentary->over = $totalOver;
            $commentary->run = 'Out, Caught and Bowled';
            $commentary->commentary = $bowlers->player. ' to '. $onStriker->name;
            $commentary->save();  
        }else{
            $whout->outStatus = $outtype." ".$helper." b ".$outby;
            $commentary->match_id = $mid;
            $commentary->innings = $inngs;
            $commentary->over = $totalOver;
            $commentary->run = 'Out';
            $commentary->commentary = $bowlers->player. ' to '. $onStriker->name;
            $commentary->save();   
        }
        


        $bowler->ball += 1;
        $bowler->wicket += 1;
        $bowler->save();


        
        $runningover ->thisover .= 'w'.',';
        $runningover ->balls +=1;
        if($whout->ball == 0){
            $whout->rating = 0;
        }else{
            $whout->rating += ($whout->run / $whout->ball)*0.05;    
        }
        
        $whout->save();



         /*
            * Add 5% of rating if a batsman score 50
            * Add 10% of rating if a batsman socre 100
            * ....
        */
        if( $striker->run >= 50 && $striker->run <100){
            $striker->runflag = 1;
        }elseif( $striker->run >= 100 && $striker->run<150){
            $striker->runflag = 2;
        }elseif( $striker->run >= 100 && $striker->run<150){
            $striker->runflag = 3;
        }elseif( $striker->run >= 150 && $striker->run<200){
            $striker->runflag = 4;
        }

        if($striker->runflag == 1){
            $striker->rating += $striker->rating * 0.05;
            $striker->runflag = 0;
        }elseif($striker->runflag == 2){
            $striker->rating += $striker->rating * 0.1;
            $striker->runflag = 0;
        }elseif($striker->runflag == 3){
            $striker->rating += $striker->rating * 0.15;
            $striker->runflag = 0;
        }elseif ($striker->runflag == 4) {
            $striker->rating += $striker->rating * 0.20;
            $striker->runflag == 0;
        }
        $striker->save();

        if($runningover->balls >= 6){
            $runningover->balls = 0;
            $striker->onStrike = false;
            $inactive->onStrike = true;
            $striker->save();
            $inactive->save();
            $runningover->overflag = 0;
            $newovers = $runningover->replicate();
            $newovers->runs = 0;
            $newovers->thisover = "";
            $newovers->overflag = 1;
            $newovers->overextra = 0;
            $newovers->bowlerextra = 0;
            $newovers->save();
     
        }

        $runningover->save();
        $value = Batsman::find($id);
        $value->isActive = false;
        $value->onStrike = false;
        $onStriker->ball += 1;
        $onStriker->save();
        $value->save();

        
        return redirect()->back();
       // return $outtype;
      //return $outted;
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
        $data = Batsman::find($id)->delete();
        return redirect()->back();
    }
}
