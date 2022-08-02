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
            Route::get('/','CategoriesController@index') ->name('admin.Categories');
            Route::get('/create','CategoriesController@create') ->name('admin.Categories.create');
            Route::post('/store','CategoriesController@store') ->name('admin.Categories.store');
            Route::get('/edit/{id}','CategoriesController@edit') ->name('admin.Categories.edit');
            Route::post('/update/{id}','CategoriesController@update') ->name('admin.Categories.update');
            Route::get('/delete/{id}','CategoriesController@destroy') ->name('admin.Categories.delete');


        });


        ################################### end Categories    ############################################


        ################################### Brands routes ############################################
        Route::group(['prefix' => 'brands'],function ()
        {
            Route::get('/','BrandsController@index') ->name('admin.brands');
            Route::get('/create','BrandsController@create') ->name('admin.brands.create');
            Route::post('/store','BrandsController@store') ->name('admin.brands.store');
            Route::get('/edit/{id}','BrandsController@edit') ->name('admin.brands.edit');
            Route::post('/update/{id}','BrandsController@update') ->name('admin.brands.update');
            Route::get('/delete/{id}','BrandsController@destroy') ->name('admin.brands.delete');


        });
        ################################### end Brands    ############################################


        ################################### tags routes ############################################
        Route::group(['prefix' => 'tags'],function ()
        {
            Route::get('/','TagsController@index') ->name('admin.tags');
            Route::get('/create','TagsController@create') ->name('admin.tags.create');
            Route::post('/store','TagsController@store') ->name('admin.tags.store');
            Route::get('/edit/{id}','TagsController@edit') ->name('admin.tags.edit');
            Route::post('/update/{id}','TagsController@update') ->name('admin.tags.update');
            Route::get('/delete/{id}','TagsController@destroy') ->name('admin.tags.delete');


        });
        ################################### end tags    ############################################
    });
    Route::group(['prefix'=>'admin','namespace'=>'Dashboard','middleware'=>'guest:admin'],function()
    {


        Route::get('login','loginController@login')->name('admin.login');
        Route::post('login','loginController@postLogin')->name('admin.post.login');
    });
});


