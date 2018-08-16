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

Route::get('/'.$current_version.'/{lang}/{category}/{subcategory}/{topic}', 'PageController@showTopic');

Route::get('/'.$current_version.'/{lang}/{category}/{subcategory}', 'PageController@showSubCategory');
