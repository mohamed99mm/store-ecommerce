<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// note that the prefix is admin for all routes
Route::group(['prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function()
{
    Route::group(['prefix'=>'admin','namespace'=>'Dashboard','middleware' =>'auth:admin'],function()
    {
        Route::get('/logout','LoginController@logout')->name('admin.logout');
        Route::get('/','DashboardController@index')-> name('admin.dashboard');
        // the first page admin visits if authenticated
        Route::group(['prefix'=> 'settings'],function()
        {
            Route::get('shipping-methods/{type}','SettingsController@editShippingMethod') ->name('edit.shipping.methods');
            Route::put('shipping-methods/{id}','SettingsController@updateShippingMethod') ->name('update.shipping.methods');
        });
    });
    Route::group(['prefix'=>'admin','namespace'=>'Dashboard','middleware'=>'guest:admin'],function()
    {

        Route::get('login','loginController@login')->name('admin.login');
        Route::post('login','loginController@postLogin')->name('admin.post.login');
    });
});


