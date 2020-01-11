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
Route::get( '/quick', 'HomeController@quick' )->name( 'quick' );

Route::get( '/dashboard', 'HomeController@dashboard' )->name( 'dashboard' )->middleware( 'verified' );

Auth::routes( [ 'verify' => true ] );

Route::get( '/culture/', 'CultureController@index' )->name( 'culture.index' );
Route::post( '/culture/', 'CultureController@generate' )->name( 'culture.generate' );
Route::get( '/culture/{guid}', 'CultureController@show' )->name( 'culture.show' );
Route::get( '/culture/{guid}/pdf', 'CultureController@pdf' )->name( 'culture.pdf' );

Route::get( '/heraldry/', 'HeraldryController@index' )->name( 'heraldry.index' );
Route::post( '/heraldry/', 'HeraldryController@generate' )->name( 'heraldry.generate' );
Route::get( '/heraldry/{guid}', 'HeraldryController@show' )->name( 'heraldry.show' );

Route::get( '/region/', 'RegionController@index' )->name( 'region.index' );
Route::post( '/region/', 'RegionController@generate' )->name( 'region.generate' );
Route::get( '/region/{guid}/ruler-device.svg', 'RegionController@device' )->name( 'region.device' );
Route::get( '/region/{guid}', 'RegionController@show' )->name( 'region.show' );
