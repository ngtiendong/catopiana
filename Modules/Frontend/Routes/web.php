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

Route::group([], function() {
    Route::get('/', 'FrontendController@index');
    Route::get('/creative', 'FrontendController@test')->name('creative');
    Route::get('/id', 'FrontendController@test')->name('id');
    Route::get('/music', 'FrontendController@music')->name('music');
    Route::get('/common', 'FrontendController@test')->name('common');
    Route::get('/difference', 'FrontendController@test')->name('difference');
    Route::get('/memory', 'FrontendController@test')->name('memory');
    Route::get('/language', 'FrontendController@test')->name('language');
    Route::get('/position', 'FrontendController@test')->name('position');
    Route::get('/getQA', 'FrontendController@getQA')->name('getQA');
    Route::get('/getQAAudio', 'FrontendController@getQAAudio')->name('getQAAudio');
});
