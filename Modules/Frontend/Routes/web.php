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
    Route::get('/language', 'FrontendController@music')->name('language');
    Route::get('/position', 'FrontendController@position')->name('position');
    Route::get('/free-test-results', 'FrontendController@resultFreeTest')->name('free-test-results');
    Route::get('/updateTestStatus', 'FrontendController@updateTestStatus')->name('update-test-status');
    Route::get('/generate_db', 'FrontendController@generate');

    //
    // Route::post('/getTopicOfPackage', 'FrontendController@getTopicOfPackage')->name('getTopicOfPackage');

    // free package ->middleware('test');
    Route::get('/physics', 'FrontendController@test')->name('physics');
    Route::get('/chemistry', 'FrontendController@test')->name('chemistry');
    Route::get('/math', 'FrontendController@test')->name('math');
    Route::get('/animal', 'FrontendController@test')->name('animal');
    // paid
    Route::get('/weather', 'FrontendController@test')->name('weather')->middleware('auth:customers');
    Route::get('/plant', 'FrontendController@test')->name('plant')->middleware('auth:customers');
    Route::get('/fruit', 'FrontendController@test')->name('fruit')->middleware('auth:customers');
    Route::get('/sport', 'FrontendController@test')->name('sport')->middleware('auth:customers');

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
    Route::get('/continue-test/{topic}', 'FrontendController@continueTest');
    Route::get('/congratulation', 'FrontendController@congratulation');



    // Route::get('/buy-package','PaymentController@buyPackage')->middleware('auth:customers')->name('buy-package');
    Route::get('/packages','FrontendController@getPackages')->middleware('test')->name('packages');
    Route::get('/free-packages','FrontendController@getCurriculumsFreePackage')->name('getCurriculumsFreePackage');
    Route::get('/paid-packages','FrontendController@getCurriculumsPaidPackage')->middleware('auth:customers')->name('getCurriculumsPaidPackage');

    Route::get('/execute-payment', 'PaymentController@execute');
    Route::post('/create-payment', 'PaymentController@create')->name('create-payment');

    Route::get('/executePayForResult', 'PaymentController@executePayForResult');
    Route::get('/payForResult', 'PaymentController@payForResult')->name('payForResult');

    Route::get('/menu', 'FrontendController@menu')->name('menu');

    Route::get('/chart', function(){
        return view('frontend::chart');
    })->name('chart');
});
