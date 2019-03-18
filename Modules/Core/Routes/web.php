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

Route::group(['middleware' => ['web'], 'prefix' => 'admin'], function()
{
    Route::get('/login', 'AdminController@login')->name('login');
    Route::post('/login', 'AdminController@loginPost')->name('login');

    Route::group(['middleware' => ['auth', 'verify.role']], function () {
        Route::get('/', 'DashboardController@index')->name('admin_home');

        Route::get('/logout', 'AdminController@logout')->name('admin_logout');

//        Route::get('/settings', 'SettingController@index')->name('core.settings.index');
//        Route::post('/settings', 'SettingController@updateSetting')->name('core.settings.update');

        Route::resource('/menu', 'MenuController', ['as' => 'core']);
        Route::resource('/menu_type', 'MenuTypeController', ['as' => 'core']);

        Route::get('/dashboard', 'DashboardController@index')->name('core.dashboard');
        Route::get('/filler_customer', 'DashboardController@filler_customer')->name('core.filler_customer');
        Route::any('/user/move', 'UserController@move')->name('insurance.customer.move');


        Route::resource('user', 'UserController', ['as' => 'core']);
        Route::post('/user/{id}/restore', 'UserController@restore')->name('core.user.restore');
        Route::post('/user/{id}/resset_password', 'UserController@resetPassword')->name('core.user.reset_password');

        Route::resource('role', 'RoleController', ['as' => 'core']);
        Route::post('/role/{id}/restore', 'RoleController@restore')->name('core.role.restore');

        Route::resource('group', 'GroupController', ['as' => 'core']);
        Route::post('/group/{id}/restore', 'GroupController@restore')->name('core.group.restore');
        Route::post('/dashboard/get-article-detail', 'DashboardController@getArticleDetail');
        Route::get('/dashboard/modal-article-detail', 'DashboardController@modalArticleDetail');


    });
});

/* API route */
Route::group(['prefix' => 'api', 'middleware' => ['api.tracking']], function () {
    Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
        Route::post('/upload-image', 'ImageController@upload')->name('api.v1.upload_image');
        Route::post('/dashboard/index', 'DashboardController@index');
        Route::post('/dashboard/get-article-detail', 'DashboardController@getArticleDetail');
        Route::post('/dashboard/get-list-article', 'DashboardController@getListArticle');
        Route::post('/dashboard/get-list-article-pag', 'DashboardController@getListArticlePag');
        Route::post('/dashboard/get-customer-agency-quotation', 'DashboardController@getCustomerAgencyQuotation');
    });
});
