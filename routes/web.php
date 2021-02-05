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
$current_version = env("CURRENT_VERSION");



Route::middleware('throttle:60|180,1')->group(function () {

        // auth routes
        Auth::routes();
        Route::post('/mycwauth', 'LoginController@login');
        Route::get('/logout', 'LoginController@logout');
        Route::get('login/azure', 'Auth\LoginController@redirectToProvider');
        Route::get('login/azure/callback', 'Auth\LoginController@handleProviderCallback');
        
        //search routes so algolia usage is not abused
        Route::get('/new-search', 'SearchController@searchform');
        Route::get('/new-search/all', 'SearchController@all'); 
        Route::get('/new-search/{query}', 'SearchController@search');
});



// ungated pages
Route::get('/', 'PageController@level1')->name('home');
Route::get('/{slug}', 'PageController@level2')->name('level2');

// gated pages
Route::group(['middleware' => 'mycasewareauth'], function () {
        
        Route::get('/{product}/{version}/{category}/{param1?}/{param2?}/{param3?}/{param4?}/{param5?}/{param6?}/{param7?}', 'PageController@showTopic')->name('topic');
});
