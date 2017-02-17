<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Batsmenrecord;
use App\Bowlerrecord;

class PredictionController extends Controller
{
    //

    public function index(){
		$bat = new Batsmenrecord;
		$ball = new Bowlerrecord;

		$batting = $bat->where('country','Ban')->orderBy('value','DESC')->get();
		$bowling = $ball->where('country','Aus')->orderBy('value','DESC')->get();

		$predictBat = [];
		$predicted_balls_batting = 0;
		$predicted_balls_bowling = 0;
		$wicket_fallen_by_batting_prediction = 0;
		$wicket_fallen_by_bowling_prediction = 0;

		for ($i = 0; $i < 11; $i++){
			$predictBat[$i] = ($batting[$i]->Gavg * 100)/($batting[$i]->Gsr);
		}

		for ($i = 0; $i < 11; $i++){
			echo $batting[$i]->Gavg.' -> '.$predictBat[$i].'<br>';
		}
		

		$sumOfBalls = 0;

		$numberOfBatsman = 0;
		for ($i = 0; $i < 11; $i++){
			$sumOfBalls += $predictBat[$i];
			if($sumOfBalls >= 300){
				$numberOfBatsman = $i+1;
				break;
			}
		}
		

		$wicket_fallen_by_batting_prediction = $numberOfBatsman - 1;

		$sum = 0;
		for($i =0 ; $i < $numberOfBatsman - 1; $i++){
			$sum += $predictBat[$i];
		}

		$sumOfRuns = 0;
		for($i = 0; $i < $numberOfBatsman-1; $i++){
			$sumOfRuns += $batting[$i]->Gavg;
		}
		
		$sumOfRuns += ((300 - $sum) * $batting[$numberOfBatsman-1]->Gsr )/100;

		//batsman over predict
		if($sumOfBalls < 300){
			$balls = 300 - $sumOfBalls;
			$predicted_balls_batting = $balls;
		}else{
			$predicted_balls_batting = 300;
		}


		echo '<br>Batsman Index = '.$numberOfBatsman.' sum = '.$sumOfBalls.'sum of run = '.$sumOfRuns.'<br>Predicted Over Batting  = '.$predicted_balls_batting;


		//Bowling part
		$predictwicket = [];
		for($i = 0; $i < 6; $i++){
			if($i < 4){
				$predictwicket[$i] = 60 / $bowling[$i]->Gavg;
			}else{
				$predictwicket[$i] = 30 / $bowling[$i]->Gavg;
			}
			
		}

		for( $i = 0 ; $i < 6; $i++){
			echo $bowling[$i]->player.'=>'.$predictwicket[$i].'<br>';
		}
		

		$sumOfWicket = 0;
		$endOfWicket = 0;
		$over = 0;
		for( $i = 0 ; $i < 6; $i++){
			$sumOfWicket += $predictwicket[$i];
			if($sumOfWicket >= 10){
				$endOfWicket = $i+1;
				$wicket_fallen_by_bowling_prediction = 10;
				break;
			}elseif($i >= 5){
				$endOfWicket = 6;
				$wicket_fallen_by_bowling_prediction = round($sumOfWicket);
				break;
			}
			
		}

		if($sumOfWicket >= 10){
			$sum = 0;
			for($i = 0; $i<$endOfWicket-1; $i++){
				$sum += $predictwicket[$i];
			}
			echo "Sum = ".$sum."<br>";
			$reminder = ((10-$sum) * $bowling[$endOfWicket-1]->Gavg);	
			$remain = 300 - $reminder;
			//$rem = $remain % 6;
			//$quo = (int)($remain / 6);
			$predicted_balls_bowling = $remain;

		}else{
			$predicted_balls_bowling = 300;
		}
		

		echo 'Remain = '.$remain.'<br>Rem = '.'<br>Over = '.$over;

		echo 'End of wicket = '.$endOfWicket.'<br>Predicted Over Bowling'.$predicted_balls_bowling;



		// Marge two prediction

		$marge_balls = 0;
		$marge_wicket = 0;

		$marge_wicket = round($wicket_fallen_by_bowling_prediction +  $wicket_fallen_by_batting_prediction) /2;

		$marge_balls = ($predicted_balls_batting + $predicted_balls_bowling)/2;

		$ball_penalty = $predicted_balls_batting - $marge_balls;
		echo "<br>Penalty balls = ".($ball_penalty/($marge_wicket+1))."</br>";


		$marge_balls_faced = [];

		for( $i = 0; $i < $marge_wicket+1; $i++){
			$marge_balls_faced[$i] = $predictBat[$i] - ($ball_penalty/($marge_wicket+1));
		}
		echo "Balls after Penalty<br>";
		for( $i = 0; $i < $marge_wicket+1; $i++){
			echo $marge_balls_faced[$i].'<br>';
		}

		//Final runs
		$final_runs = [];
		$final_runs_sum = 0;
		for($i = 0; $i < $marge_wicket+1;$i++){
			$final_individual_run[$i] = ($batting[$i]->Gsr * $marge_balls_faced[$i])/100;
			$final_runs_sum += $final_individual_run[$i];
		}
		echo "<br>Final runs : <br>";
		for($i = 0; $i < $marge_wicket+1;$i++){
			echo $final_individual_run[$i]."</br>";
		}
		$final_predicted_run = round($final_runs_sum);
		echo "<br>Final predicted Run = ".$final_predicted_run;

    }
}
