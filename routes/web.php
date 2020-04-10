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
    return view('index');
});

Route::get('/shop', 'ShopController@index');

Route::get('/cart', 'CartController@index');

Route::get('/checkout', 'CartController@checkout');
Route::post('/checkout', 'CartController@saveorder');
Route::get('/thanks', 'CartController@thanks');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/signup', 'AuthController@showRegister');

Route::get('/log_in', 'AuthController@showLogin');
