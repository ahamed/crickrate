<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batsman;
use App\Player;
use App\Over;

class AddplayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id1, $id2)
    {
        $bats = Batsman::all();
        $totalRuns = Over::all()->sum('runs');
        $ind = 1;
        $records = Batsman::where('isActive',1)->get();
        $howMany = count($records);
        $wickets = count($bats) - 2;
        $overs = Over::all();

        


        $bowlersRecords = Over::where('match_id',1)->where('innings','1st')->select(\DB::raw('sum(runs) as runOfOver,cap'))->groupBy('cap')->get();

         $overextra = Over::where('match_id',1)->where('innings','1st')->select(\DB::raw('sum(overextra) as extra'))->groupBy('cap')->get();

         $totalOvers = Over::where('match_id',1)->where('innings','1st')->select(\DB::raw('count(*) as over'))->groupBy('cap')->get();

         $bowlerName = [];

         for( $i = 0; $i < sizeof($bowlersRecords); $i++ ){

            $bowlerName[$i] = Player::where('cap',$bowlersRecords[$i]['cap'])->first();
         }
        



         
         $finalValue = [];
         for( $i = 0; $i< sizeof($overextra); $i++){
            $finalValue[$i] = (int)($bowlersRecords[$i]['runOfOver']) - (int)($overextra[$i]['extra']); 
            if($finalValue[$i] <= 0){
                $finalValue[$i] = 0;
            }
         }

     

        $thisover = Over::where('match_id',1)->where('innings','1st')->where('overflag',1)->get()->first();
        if($howMany >= 2){
            $overcount = ($thisover->id-1) .'.'. $thisover->balls;
            $thisovers = explode(',',$thisover->thisover);
        }else{
            $thisovers = NULL;
            $overcount = 0;
        }
        // this query is temporary
        // Must be cnaged
        




        // Retrive data from players table 
        $batsmen = Player::where('country',$id1)->get();
        $bowlers = Player::where('country',$id2)->get();

        
        return view('control-panel.cpanel',compact('bats'))->with('ind',$ind)->with('pitch',$howMany)->with('batsmen',$batsmen)->with('bowlers',$bowlers)->with('thisovers',$thisovers)->with('total_runs',$totalRuns)->with('batting',$id1)->with('bowling',$id2)->with('overcount',$overcount)->with('wickets',$wickets)->with('current_batsmen',$records)->with('all_bowlers',$finalValue)->with('bowlerNames',$bowlerName)->with('totalOver',$totalOvers);
        //return $totalOvers;
      
       
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
    public function store(Request $request)
    {
        //add player from this function
        $batsman = new Batsman;
        $batsman->match_id = '1';
        $batsman->name = $request->playername;
        $batsman->run = 0;
        $batsman->ball = 0;
        $batsman->sr = 0.0;
        $batsman->fours = 0;
        $batsman->sixs = 0;
        $batsman->isActive = true;

        $strike = Batsman::where('onStrike',1)->get();
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
    public function edit($id)
    {

        $over = new Over;
        $batsman = new Batsman;
        $onStriker = $batsman->where('onStrike',1)->get()->first();

        $runningover = $over->where('overflag',1)->get()->first();
        $runningover ->thisover .= 'w'.',';
        $runningover ->balls +=1;
        $runningover->save();
        $value = Batsman::find($id);
        $value->isActive = false;
        $value->onStrike = false;
        $onStriker->ball += 1;
        $onStriker->save();
        $value->save();
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
        $data = Batsman::find($id)->delete();
        return redirect()->back();
    }
}
