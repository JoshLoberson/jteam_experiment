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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'user'], function(){
    Route::group(['prefix' => 'auth'], function(){
        Route::get('/social-sign-in/{provider?}',['as' => 'auth.getSocialAuth', 'uses' => 'UserAuthController@SignInProcess']);
        Route::get('/social-sign-in-callback/{provider?}',['as' => 'auth.getSocialAuthCallback', 'uses' => 'UserAuthController@SignInCallbackProcess']);
    });
});