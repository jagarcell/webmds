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

Auth::routes();

Route::get('/productsingroup', 'MainMenuController@productsingroup');

Route::get('/', 'MainMenuController@welcome');


Route::get('/lang/{locale}', function($locale){
	session(['lang' => $locale]);
    App::setLocale(session('lang'));
	return redirect()->back();
});

Route::get('/translatedGroupUpdate', 'MainMenuController@translatedGroupUpdate');

Route::get('/translatedProductUpdate', 'MainMenuController@translatedProductUpdate');

Route::get('/groups', 'MainMenuController@groups');

Route::get('/groupbyid', 'MainMenuController@groupbyid');

Route::get('/productbyid', 'MainMenuController@productbyid');

Route::post('/grouptranslationupdate', 'MainMenuController@grouptranslationupdate');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/about', 'MainMenuController@about');

Route::get('/contact', 'MainMenuController@contact');

Route::get('/delivery', 'MainMenuController@delivery');

Route::get('/news', 'MainMenuController@news');

Route::get('/products/{group}', 'MainMenuController@products');

Route::get('/import', 'MainMenuController@import');

Route::get('/adminpanel/{translang}/{baselang}', 'MainMenuController@adminpanel');

Route::get('/findgroups/{group}', 'MainMenuController@findgroups');
