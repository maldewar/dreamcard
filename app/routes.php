<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
Route::get('/', function()
{
	return View::make('index');
});
*/
Route::get('/', 'PanelController@useCredit');

Route::get( '/locale/{locale}', 'BaseController@setLocale' );

// Panel
Route::get('useCredit', 'PanelController@useCredit');
Route::get('useCredit/card/{id}', 'PanelController@useCreditCard');
Route::post('useCredit/card/{id}', 'PanelController@useCreditCardPost');
Route::get('addCredit', 'PanelController@addCredit');
Route::post('addCredit', 'PanelController@addCreditPost');
Route::get('myCards', 'PanelController@myCards');
Route::get('myCards/{code}/claim', 'PanelController@claimCard');
Route::post('myCards/{code}/claim', 'PanelController@claimCardPost');
Route::get('myCards/{code}', 'PanelController@viewCard');
Route::get('history', 'PanelController@history');
Route::get('settings', 'PanelController@settings');


// Confide RESTful route
Route::get('users/confirm/{code}', 'UsersController@getConfirm');
Route::get('users/reset_password/{token}', 'UsersController@getReset');
Route::get('users/reset_password', 'UsersController@postReset');
Route::controller( 'users', 'UsersController');
App::bind('confide.user_validator', 'DreamcardUserValidator');

// Cards
Route::resource('cards', 'CardsController');


//Route::resource('transactions', 'TransactionsController');
//Route::resource('cardinstances', 'CardinstancesController');


// Temporal Youtube API consumption
Route::get('youtube/consume', 'YoutubeController@search');


Route::resource('yt_results', 'Yt_resultsController');

Route::resource('ytresults', 'YtresultsController');

Route::get('/login', 'UsersController@getLogin');
