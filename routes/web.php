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
Route::get('set-lang/{lang}', 'LanguageController@setLanguage');
Route::post('/search', 'ProductController@searchProducts');
Route::post('/search-to-price', 'ProductController@searchProductsToPrice');
Route::get('/export-csv', 'ProductController@exportCsvFile');
Route::get('/send-email', 'EmailController@sendEmailAndGenaratePDF');
Route::get('/download_pdf', 'EmailController@downloadPdfFile');
Route::resource('products','ProductController');