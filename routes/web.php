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

Route::get( '/', 'HomeController@index' )->name( 'index' );
Route::get( '/region/', 'RegionController@index' )->name( 'region.index' );
Route::post( '/region/', 'RegionController@generate' )->name( 'region.generate' );
Route::get( '/region/{guid}', 'RegionController@show' )->name( 'region.show' );
