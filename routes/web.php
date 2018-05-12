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

Route::get('/', 'ProductController@index');
Route::get('set_lang/{lang}', 'LanguageController@setLanguage');
Route::post('/search', 'ProductController@searchProducts');
Route::post('/search_to_price', 'ProductController@searchProductsToPrice');
Route::resource('products','ProductController');