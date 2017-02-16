<?php


Auth::routes();



//Routes for scoreboard and score generation...

Route::get('/scoreboard/{id1}/{id2}/{id3}',['as'=>'display','uses'=>'DisplayController@index']);



Route::group(['middleware'=>'auth'],function(){
	Route::post('/score','initController@makeGame');
	
Route::get('/score-control',function(){
	return view('control-panel.score-controll');
});
Route::get('/home', 'HomeController@index');
Route::get('/cpanel/{id1}/{id2}/{id3}/{id4}',function(){
	return view('control-panel.cpanel');
});
Route::post('/add-player/{id1}/{id2}','AddplayerController@store'); // add a player to database 
Route::get('/cpanel/{id1}/{id2}/{id3}/{id4}','AddplayerController@index'); // get data from players table

//Route::get('/cpanel/{id1}/{id2}','PlayersController@index');
Route::post('/out/{id1}/{id2}/{id3}','AddplayerController@edit'); // Edit batsman data
Route::get('/delete/{id}','AddplayerController@destroy'); // Delete a batsman
Route::post('/add-runs/{id1}/{id2}','RunController@addRun'); // Add run to database
Route::get('/add-batsman','RecordController@create'); 
Route::post('/records','RecordController@store');
Route::get('/show-batsmen/{coun}','RecordController@index'); // See records and point of a player
Route::get('/add-bowler','BowlerController@create'); // Fetch a form for adding a bowler data
Route::post('/bowlers','BowlerController@store'); // Store bowler data in bowers table
//Route::post('/current-bowler','RunController@addRun'); // Sotre current bowler in bowlers table.
Route::post('/current-bowler/{id1}/{id2}','AddBowlerController@store'); // Sotre current bowler in bowlers table.
Route::get('/clear/{id1}/{id2}','RunController@clearAll');


//Route for profile
Route::get('/profile/{id}',function(){
	return view('profile.profile');
});


//Routes for blog 
Route::get('/write','PostController@create');
Route::post('/save-story','PostController@store');
Route::post('/comment/{id}','PostController@storeComments');
Route::post('/reply/{id1}/{id2}','PostController@storeReplies');

});



//Route for blog purpose
Route::get('/cricblog','PostController@index');
Route::get('/story/{id}','PostController@storyIndex');



//Routes for faq purpose
Route::get('/ask-question',function(){
	return view('cric-faq.ask');
});

Route::get('/cricfaq',function(){
	return view('cric-faq.home');
});



Route::get('/question/{id}',function(){
	return view('cric-faq.faq');
});

Route::get('/ask',function(){
	return view('cric-faq.ask');
});