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

Route::group(/**
 *
 */ [], function() {
    Route::get('/', 'FrontendController@index')->name('home');
    Route::get('/music', 'FrontendController@music')->name('music');
    Route::get('/iq', 'FrontendController@test')->name('iq');
    Route::get('/creative', 'FrontendController@test')->name('creative');
    Route::get('/difference', 'FrontendController@test')->name('difference');

    Route::get('/common', 'FrontendController@test')->name('common');
    Route::get('/memory', 'FrontendController@test')->name('memory');
    Route::get('/language', 'FrontendController@test')->name('language');
    Route::get('/position', 'FrontendController@position')->name('position');
    Route::get('/free-test-results', 'FrontendController@resultFreeTest')->name('position');
    Route::get('/updateTestStatus', 'FrontendController@updateTestStatus')->name('update-test-status');

    // free package
    Route::get('/physics', 'FrontendController@test')->name('physics')->middleware('test');
    Route::get('/chemistry', 'FrontendController@test')->name('chemistry')->middleware('test');
    Route::get('/math', 'FrontendController@test')->name('math')->middleware('test');
    Route::get('/animal', 'FrontendController@test')->name('animal')->middleware('test');
    Route::get('/weather', 'FrontendController@test')->name('weather')->middleware('test');
    Route::get('/plant', 'FrontendController@test')->name('plant')->middleware('test');
    Route::get('/fruit', 'FrontendController@test')->name('fruit')->middleware('test');
    Route::get('/sport', 'FrontendController@test')->name('sport')->middleware('test');

    Route::post('/get-list-question', 'FrontendController@getListQuestion');
    Route::post('/get-list-less-level-question', 'FrontendController@getListLessLevelQuestion');

    Route::get('/register', 'Auth\RegistrationController@showRegistrationForm')->name('register');
    Route::post('/register', 'Auth\RegistrationController@register');

    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::post('/generate-account','Auth\RegistrationController@generateAccountEmail')->name('generate-account');
    Route::post('/generate','Auth\RegistrationController@generateAccount')->name('generate');

    Route::get('/login/{provider}','Auth\SocialAccountController@redirectToProvider')->name('social');
    Route::get('/login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
    Route::post('/sendLocalStorageSocial', 'Auth\SocialAccountController@sendLocalStorageSocial');

    Route::post('/updateDataTesting', 'Auth\LoginController@updateDataTesting');



    // Route::get('/buy-package','PaymentController@buyPackage')->middleware('auth:customers')->name('buy-package');
    Route::get('/packages','FrontendController@getPackages')->middleware('auth:customers')->name('packages');
    Route::get('/free-packages','FrontendController@getCurriculumsFreePackage')->middleware('auth:customers')->name('getCurriculumsFreePackage');
    Route::get('/paid-packages','FrontendController@getCurriculumsPaidPackage')->middleware('auth:customers')->name('getCurriculumsPaidPackage');
    
    Route::get('/execute-payment', 'PaymentController@execute');
    Route::post('/create-payment', 'PaymentController@create')->name('create-payment');
});
