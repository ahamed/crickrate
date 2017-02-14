<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Batsman;
use App\Player;
use App\Over;
use App\Bowler;
use App\Commentary;

class DisplayController extends Controller
{
     public function index($id1, $id2,$id3)
    {	
    	$id4 = "1st";
        $bats1st = Batsman::where('match_id',$id3)->where('innings',$id4)->get();
        $totalRuns1st = Over::where('match_id',$id3)->where('innings',$id4)->sum('runs');
        $ind1st = 1;
        $records1st = Batsman::where('match_id',$id3)->where('innings',$id4)->where('isActive',1)->get();
        $howMany1st = count($records1st);
        $wickets1st = count($bats1st) - 2;
        $overs1st = Over::all();

        $time_to_select_bowler1st = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1)->get()->count();


        


        $bowlersRecords1st= Bowler::where('match_id',$id3)->where('innings',$id4)->get();
        $totalOver1st = Bowler::where('match_id',$id3)->where('innings',$id4)->get()->sum('over');
        $Ball1st = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1)->get()->first();
        $checkBall1st = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1);
        if($checkBall1st->exists()){
            $totalBall1st = $Ball1st->ball;
            $overcount1st = $totalOver1st.".".$totalBall1st;    
        }else{
            $totalBall1st = 0;
            $overcount1st = $totalOver1st.".".$totalBall1st;    
        }
        


         $overextra1st = Over::where('match_id',$id3)->where('innings',$id4)->select(\DB::raw('sum(overextra) as extra'))->groupBy('cap')->get();

         $totalOvers1st = Over::where('match_id',$id3)->where('innings',$id4)->select(\DB::raw('count(*) as over'))->groupBy('cap')->get();

         $bowlerName1st = [];

         for( $i = 0; $i < sizeof($bowlersRecords1st); $i++ ){

            $bowlerName1st[$i] = Player::where('cap',$bowlersRecords1st[$i]->cap)->get()->first();
         }
        



      

     

        $thisover1st = Over::where('match_id',$id3)->where('innings',$id4)->where('overflag',1)->get()->first();

        if(Over::where('match_id',$id3)->where('innings',$id4)->exists()){
            if($howMany1st >= 2){
                // $overcount = ($thisover->id-1) .'.'. $thisover->balls;
                $thisovers1st = explode(',',$thisover1st->thisover);
            }else{
                $thisovers1st = NULL;
                $overcount1st = 0;
             }    
        }else{
            $over1st = new Over;
            $over1st->match_id = $id3;
            $over1st->innings = $id4;
            $over1st->runs = 0;
            $over1st->balls = 0;
            $over1st->overflag = 1;
            $over1st->overextra = 0;
            $over1st->bowlerextra = 0;
            $over1st->overno = 0;
            $over1st->save();
            $thisovers1st = NULL;
        }
   

		

		//retrieve commentary here
		$commentaries1st = Commentary::where('match_id',$id3)->where('innings',$id4)->orderBy('over','DESC')->paginate(10);

        // Retrive data from players table 
        $batsmen1st = Player::where('country',$id1)->get();
        $bowlers1st = Player::where('country',$id2)->get();

        //Check if the 1st innings is started or not
        $is_game_started_1st = Batsman::where('match_id',$id3)->where('innings','1st')->get()->count();
        
        $extra1st = Bowler::where('match_id',$id3)->where('innings','1st')->get()->sum('extra');

        

		//End 1st innings


        /*
        *	This for 2nd innings
        *	Declare all variables for 2nd innings
        *	Name with suffix 2nd
        */

		$id4 = "2nd";
        $bats2nd = Batsman::where('match_id',$id3)->where('innings',$id4)->get();
        $totalRuns2nd = Over::where('match_id',$id3)->where('innings',$id4)->sum('runs');
        $ind2nd = 1;
        $records2nd = Batsman::where('match_id',$id3)->where('innings',$id4)->where('isActive',1)->get();
        $howMany2nd = count($records2nd);
        $wickets2nd = count($bats2nd) - 2;
        $overs2nd = Over::all();

        $time_to_select_bowler2nd = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1)->get()->count();


        


        $bowlersRecords2nd= Bowler::where('match_id',$id3)->where('innings',$id4)->get();
        $totalOver2nd = Bowler::where('match_id',$id3)->where('innings',$id4)->get()->sum('over');
        $Ball2nd = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1)->get()->first();
        $checkBall2nd = Bowler::where('match_id',$id3)->where('innings',$id4)->where('onStrike',1);
        if($checkBall2nd->exists()){
            $totalBall2nd = $Ball2nd->ball;
            $overcount2nd = $totalOver2nd.".".$totalBall2nd;    
        }else{
            $totalBall2nd = 0;
            $overcount2nd = $totalOver2nd.".".$totalBall2nd;    
        }
        


         $overextra2nd = Over::where('match_id',$id3)->where('innings',$id4)->select(\DB::raw('sum(overextra) as extra'))->groupBy('cap')->get();

         $totalOvers2nd = Over::where('match_id',$id3)->where('innings',$id4)->select(\DB::raw('count(*) as over'))->groupBy('cap')->get();

         $bowlerName2nd = [];

         for( $i = 0; $i < sizeof($bowlersRecords2nd); $i++ ){

            $bowlerName2nd[$i] = Player::where('cap',$bowlersRecords2nd[$i]->cap)->get()->first();
         }
        



      

     

        $thisover2nd = Over::where('match_id',$id3)->where('innings',$id4)->where('overflag',1)->get()->first();

        if(Over::where('match_id',$id3)->where('innings',$id4)->exists()){
            if($howMany1st >= 2){
                // $overcount = ($thisover->id-1) .'.'. $thisover->balls;
                $thisovers2nd = explode(',',$thisover2nd->thisover);
            }else{
                $thisovers2nd = NULL;
                $overcount2nd = 0;
             }    
        }else{
            $over2nd = new Over;
            $over2nd->match_id = $id3;
            $over2nd->innings = $id4;
            $over2nd->runs = 0;
            $over2nd->balls = 0;
            $over2nd->overflag = 1;
            $over2nd->overextra = 0;
            $over2nd->bowlerextra = 0;
            $over2nd->overno = 0;
            $over2nd->save();
            $thisovers2nd = NULL;
        }
   

		

		//retrieve commentary here
		$commentaries2nd = Commentary::where('match_id',$id3)->where('innings',$id4)->orderBy('over','DESC')->paginate(10);

        // Retrive data from players table 
        $batsmen2nd = Player::where('country',$id1)->get();
        $bowlers2nd = Player::where('country',$id2)->get();

        
		//Check if the 2nd innings is started or not
        $is_game_started_2nd = Batsman::where('match_id',$id3)->where('innings','2nd')->count();
        $extra2nd = Bowler::where('match_id',$id3)->where('innings','2nd')->sum('extra');
        //End 2nd innings


        //Return all the variables including 1st and 2nd innings
        return view('display.scoreboard',compact('bats1st'))->with('ind1st',$ind1st)->with('pitch1st',$howMany1st)->with('batsmen1st',$batsmen1st)->with('bowlers1st',$bowlers1st)->with('thisovers1st',$thisovers1st)->with('total_runs1st',$totalRuns1st)->with('batting1st',$id1)->with('bowling1st',$id2)->with('overcount1st',$overcount1st)->with('wickets1st',$wickets1st)->with('current_batsmen1st',$records1st)->with('bowlerNames1st',$bowlerName1st)->with('totalOver1st',$totalOvers1st)->with('all_bowlers1st',$bowlersRecords1st)->with('isTime1st',$time_to_select_bowler1st)->with('mid',$id3)->with('inngs',$id4)->with('commentaries1st',$commentaries1st)->with('ind2nd',$ind2nd)->with('pitch2nd',$howMany2nd)->with('batsmen2nd',$batsmen2nd)->with('bowlers2nd',$bowlers2nd)->with('thisovers2nd',$thisovers2nd)->with('total_runs2nd',$totalRuns2nd)->with('batting2nd',$id1)->with('bowling2nd',$id2)->with('overcount2nd',$overcount2nd)->with('wickets2nd',$wickets2nd)->with('current_batsmen2nd',$records2nd)->with('bowlerNames2nd',$bowlerName2nd)->with('totalOver2nd',$totalOvers2nd)->with('all_bowlers2nd',$bowlersRecords2nd)->with('isTime2nd',$time_to_select_bowler2nd)->with('mid',$id3)->with('inngs',$id4)->with('commentaries2nd',$commentaries2nd)->with('start1st',$is_game_started_1st)->with('start2nd',$is_game_started_2nd)->with('extra1st',$extra1st)->with('extra2nd',$extra2nd);
        
        
      
       
    }






}
