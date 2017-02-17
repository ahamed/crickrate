<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Question;
use App\Answer;
use App\Answercomment;

class FaqController extends Controller
{
    public function index(){
		$questions = Question::all();
		return view('cric-faq.home',compact('questions'));
    }

    public function store(Request $request){
		$que = new Question;
		$que->title = $request->title;
		$que->user_id = Auth::user()->id;
		$que->question = $request->question;
		$que->vote = 0;
		$que->favorit = 0;
		$que->tag = $request->tag;
		$que->save();
		return redirect()->back();
    }

	public function answerComment(Request $request, $id1, $id2){
		$anscomment = new Answercomment;
		$anscomment->question_id = $id1;
		$anscomment->answer_id = $id2;
		$anscomment->user_id = Auth::user()->id;
		$anscomment->comment = $request->anscomment;
		$anscomment->save();
		return redirect()->back();
	}

    public function answer(Request $request,$id){

		$ans = new Answer;
		$ans->question_id = $id;
		$ans->user_id = Auth::user()->id;
		$ans->answer = $request->answer;
		$ans->vote = 0;
		$ans->isAccepted = true;
		$ans->save();
    	return redirect()->back();
    }


	public function show($id){

		$resources = Question::where('id',$id)->get()->first();
		//return $resources;

		$answers = Answer::where('question_id',$id)->get();
		$answer_comments = Answercomment::where('question_id',$id)->get();
		return view('cric-faq.faq',compact('resources','answers','answer_comments'));
	}

}
