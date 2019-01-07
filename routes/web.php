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

// Route::get('/', function () {
//      return view('welcome');
// });
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/', 'HomeController@process')->name('uploadfile');
Route::get('/php-to-excel','HomeController@phpform')->name('phpexcelform');
Route::post('/php-to-excel','HomeController@processphpform')->name('uploadphpfile');

/*
Multiple File and Zip
*/
Route::get('/php-files-to-excel','MultipleController@phpzipform')->name('phpzipform');
Route::post('/php-files-to-excel','MultipleController@processphpzipform')->name('uploadzipphpfile');
Route::get('/excel-sheets-to-zip','MultipleController@multiplesheetform')->name('multiplesheetform');
Route::post('/excel-sheets-to-zip','MultipleController@processmultiplesheets')->name('processmultiplesheets');

/*
Demo and Format Data
*/
Route::get('/demo-data','HomeController@demopage')->name('demopage');
Route::get('/download/excel',function(){
    return Response::download('downloads/validation.xlsx','validation.xlsx');
})->name('demosingleexcel');
Route::get('/download/php',function(){
  return Response::download('downloads/validation.php','validation.php');
})->name('demosinglephp');
Route::get('/download/multi-excel',function(){
  return Response::download('downloads/en.xlsx','en.xlsx');
})->name('demomultipleexcel');
Route::get('/download/multi-zip',function(){
    return Response::download('downloads/en.zip','en.zip');
})->name('demomultiplezip');
