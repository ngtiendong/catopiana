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
    Route::get('/music-{type}', 'FrontendController@music')->name('music');
    Route::get('/iq-{type}', 'FrontendController@test')->name('iq');
    Route::get('/creative-{type}', 'FrontendController@test')->name('creative');
    Route::get('/difference-{type}', 'FrontendController@test')->name('difference');

    Route::get('/common-{type}', 'FrontendController@test')->name('common');
    Route::get('/memory-{type}', 'FrontendController@test')->name('memory');
    Route::get('/language-{type}', 'FrontendController@test')->name('language');
    Route::get('/position-{type}', 'FrontendController@test')->name('position');
    Route::get('/getQA', 'FrontendController@getQA')->name('getQA');
    Route::get('/getQAAudio', 'FrontendController@getQAAudio')->name('getQAAudio');


    Route::post('/get-list-question', 'FrontendController@getListQuestion');
});
