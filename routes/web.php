<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/article','ArticleController@Index');
Route::get('/article/test','ArticleController@test');
Route::get('/test/{phone}','ArticleController@send');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
	'namespace'=>'Api',
],function(){
	Route::post('VerificationCodes','VerificationCodesController@send');
});


