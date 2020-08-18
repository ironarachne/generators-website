<?php

use Illuminate\Http\Request;

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

Route::middleware( 'auth:api' )->get( '/user', function ( Request $request ) {
    return $request->user();
} );

Route::get('/alcoholic_drink', 'ApiController@randomAlcoholicDrink')->name('api.alcoholicdrink.random');
Route::get('/alcoholic_drink/{seed}', 'ApiController@randomAlcoholicDrinkSeed')->name('api.alcoholicdrink.seed');

Route::get('/clothing_style', 'ApiController@randomClothingStyle')->name('api.clothingstyle.random');
Route::get('/clothing_style/{seed}', 'ApiController@randomClothingStyleSeed')->name('api.clothingstyle.seed');

Route::get('/geography', 'ApiController@randomGeographicRegion')->name('api.geographicregion.random');
Route::get('/geography/{seed}', 'ApiController@randomGeographicRegionSeed')->name('api.geographicregion.seed');

Route::get('/language', 'ApiController@randomLanguage')->name('api.language.random');
Route::get('/language/{seed}', 'ApiController@randomLanguageFromSeed')->name('api.language.seed');

Route::get('/music', 'ApiController@randomMusic')->name('api.music.random');
Route::get('/music/{seed}', 'ApiController@randomMusicFromSeed')->name('api.music.seed');
