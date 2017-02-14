<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class initController extends Controller
{
    public function makeGame(Request $request){
		$team1 = $request->team1;
		$team2 = $request->team2;
		$inngs = $request->innings;
		$mid   = $request->match_id;
		$urlValue = [$team1,$team2,$mid,$inngs];
		return redirect('/cpanel/'.$team1.'/'.$team2.'/'.$mid.'/'.$inngs);
    }
}
