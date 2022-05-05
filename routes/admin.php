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

        Route::group(['prefix'=> 'profile'],function()
        {
            Route::get('edit','ProfileController@editProfile') ->name('edit.profile');
            Route::put('update','ProfileController@updateProfile') ->name('update.profile');
         //   Route::put('update/password','ProfileController@updatePassword') ->name('update.profile.password');
        });

        ################################### Categories routes ############################################
        Route::group(['prefix' => 'main_categories'],function ()
        {
            Route::get('/','MainCategoriesController@index') ->name('admin.mainCategories');
            Route::get('/create','MainCategoriesController@create') ->name('admin.mainCategories.create');
            Route::post('/store','MainCategoriesController@store') ->name('admin.mainCategories.store');
            Route::get('/edit/{id}','MainCategoriesController@edit') ->name('admin.mainCategories.edit');
            Route::post('/update/{id}','MainCategoriesController@update') ->name('admin.mainCategories.update');
            Route::get('/delete/{id}','MainCategoriesController@destroy') ->name('admin.mainCategories.delete');


        });


        ################################### end Categories    ############################################

        ################################### SubCategories routes ############################################
        Route::group(['prefix' => 'sub_categories'],function ()
        {
            Route::get('/','SubCategoriesController@index') ->name('admin.subCategories');
            Route::get('/create','SubCategoriesController@create') ->name('admin.subCategories.create');
            Route::post('/store','SubCategoriesController@store') ->name('admin.subCategories.store');
            Route::get('/edit/{id}','SubCategoriesController@edit') ->name('admin.subCategories.edit');
            Route::post('/update/{id}','SubCategoriesController@update') ->name('admin.subCategories.update');
            Route::get('/delete/{id}','SubCategoriesController@destroy') ->name('admin.subCategories.delete');


        });


        ################################### end SubCategories    ############################################
    });
    Route::group(['prefix'=>'admin','namespace'=>'Dashboard','middleware'=>'guest:admin'],function()
    {


        Route::get('login','loginController@login')->name('admin.login');
        Route::post('login','loginController@postLogin')->name('admin.post.login');
    });
});


