<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('category/deletedprojects', 'CategoryController@getDeleteProjects')->name('getDeleteProjects');
Route::get('category/deletedprojects/{id}', 'CategoryController@restoreDeletedProjects')->name('restoreDeletedProjects');
Route::get('category/retoreprojects/{id}', 'CategoryController@deletePermanently')->name('deletePermanently');


Route::resource('category', CategoryController::class);