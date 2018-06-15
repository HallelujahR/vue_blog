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

//用户
Route::get('/user/{id?}','UserController@index');

//文章
Route::get('/article','ArticleController@Index');
Route::get('/article/test','ArticleController@test');
Route::post('/article/createArticle','ArticleController@createArticle');
Route::post('/article/getAll','ArticleController@getAll');
Route::get('/article/agree/{id?}','ArticleController@agree');
Route::get('/article/detail/{id?}','ArticleController@detail');
Route::post('/article/detail','ArticleController@getArticleDetail');
Route::get('/article/collection/{id?}','ArticleController@collection');
Route::post('/article/comment','ArticleController@comment');
Route::get('/article/getComment/{id?}','ArticleController@getComment');
Route::get('/article/commentAgree/{id?}','ArticleController@commentAgree');
Route::get('/article/commentDel','ArticleController@commentDel');
Route::get('/article/delete/{id?}','ArticleController@delete');
Route::post('/article/edit','ArticleController@edit');

//问题
Route::get('/question','QuestionController@index');

Route::post('/question/createQuestion','QuestionController@createQuestion');
Route::get('/test/{phone}','ArticleController@send');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
	'namespace'=>'Api',
],function(){
	Route::post('VerificationCodes','VerificationCodesController@send');
});


Route::post('/getTopic','TopicController@getTopic');
