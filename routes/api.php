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

Route::get('/alcoholic_drink', 'ApiController@randomAlcoholicDrink')->name('api.alcoholic_drink.random');
Route::get('/alcoholic_drink/{seed}', 'ApiController@randomAlcoholicDrinkSeed')->name('api.alcoholic_drink.seed');

Route::get('/character', 'ApiController@randomCharacter')->name('api.character.random');
Route::get('/character/{seed}', 'ApiController@randomCharacterSeed')->name('api.character.seed');

Route::get('/cuisine', 'ApiController@randomCuisine')->name('api.cuisine.random');
Route::get('/cuisine/{seed}', 'ApiController@randomCuisineSeed')->name('api.cuisine.seed');

Route::get('/clothing_style', 'ApiController@randomClothingStyle')->name('api.clothing_style.random');
Route::get('/clothing_style/{seed}', 'ApiController@randomClothingStyleSeed')->name('api.clothing_style.seed');

Route::get('/geography', 'ApiController@randomGeographicRegion')->name('api.geography.random');
Route::get('/geography/{seed}', 'ApiController@randomGeographicRegionSeed')->name('api.geography.seed');

Route::get('/language', 'ApiController@randomLanguage')->name('api.language.random');
Route::get('/language/{seed}', 'ApiController@randomLanguageFromSeed')->name('api.language.seed');

Route::get('/music', 'ApiController@randomMusic')->name('api.music.random');
Route::get('/music/{seed}', 'ApiController@randomMusicFromSeed')->name('api.music.seed');

Route::get('/religion', 'ApiController@randomReligion')->name('api.religion.random');
Route::get('/religion/{seed}', 'ApiController@randomReligionFromSeed')->name('api.religion.seed');
