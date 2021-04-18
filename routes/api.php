<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admins','jwt.auth']],function ()
// {
// 	Route::get('/demo','AdminController@demo');	
// });

Route::get('/search','App\Http\Controllers\ProductController@search');	

Route::resource('/products', 'App\Http\Controllers\ProductController');
Route::get('/product/{store}', 'App\Http\Controllers\ProductController@showProd');
Route::get('/store/{id}', 'App\Http\Controllers\SellerController@showPub');
Route::get('/company/{store}', 'App\Http\Controllers\SellerController@showSellerByAlias');

Route::post('/payment', 'App\Http\Controllers\CieloController@payer');

Route::group(['prefix' => 'seller','middleware' => []],function ()
{
	Route::post('/create', 'App\Http\Controllers\SellerController@store');
	Route::post('/login', 'App\Http\Controllers\SellerController@login');
	Route::post('/verify-access','App\Http\Controllers\SellerController@verifyAccess');	
});

Route::group(['prefix' => 'seller','middleware' => ['assign.guard:sellers','jwt.auth']],function ()
{
	Route::get('/data', 'App\Http\Controllers\SellerController@show');
	Route::put('/update', 'App\Http\Controllers\SellerController@update');
	Route::post('/logout', 'App\Http\Controllers\SellerController@logout');
	// Route::delete('/delete', 'App\Http\Controllers\SellerController@delete');
});

// Users
Route::group(['prefix' => 'user','middleware' => []],function ()
{
	Route::post('/create','App\Http\Controllers\UserController@store');
	Route::post('/login', 'App\Http\Controllers\UserController@login');
	Route::get('/data', 'App\Http\Controllers\UserController@show');
	Route::put('/update', 'App\Http\Controllers\UserController@update');
});

Route::group(['prefix' => 'user','middleware' => ['assign.guard:sellers','jwt.auth']],function ()
{
	Route::get('/list','App\Http\Controllers\UserController@index');	
});