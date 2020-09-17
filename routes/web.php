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

Route::get('/test1/{n?}',  ['as'=>'q1', 'uses'=>'QuestionController@q1']);
Route::get('/test2/{action?}/{itemId?}',  ['as'=>'q2', 'uses'=>'QuestionController@q2']);
Route::get('/test3',  ['as'=>'q3', 'uses'=>'QuestionController@q3']);