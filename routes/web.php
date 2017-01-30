<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/cpanel/{id1}/{id2}',function(){
	return view('control-panel.cpanel');
});
Route::post('/add-player','AddplayerController@store'); // add a player to database 
Route::get('/cpanel/{id1}/{id2}','AddplayerController@index'); // get data from players table

//Route::get('/cpanel/{id1}/{id2}','PlayersController@index');
Route::get('/out/{id}','AddplayerController@edit'); // Edit batsman data
Route::get('/delete/{id}','AddplayerController@destroy'); // Delete a batsman
Route::post('/add-runs','RunController@addRun'); // Add run to database
Route::get('/add-batsman','RecordController@create'); 
Route::post('/records','RecordController@store');
Route::get('/show-batsmen/{coun}','RecordController@index'); // See records and point of a player
Route::get('/add-bowler','BowlerController@create'); // Fetch a form for adding a bowler data
Route::post('/bowlers','BowlerController@store'); // Store bowler data in bowers table
Route::post('/current-bowler','RunController@addRun'); // Sotre current bowler in bowlers table.

