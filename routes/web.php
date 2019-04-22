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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/subjects', 'SubjectsController@index');
Route::post('/subjects', 'SubjectsController@store');

Route::post('/subjects/join_group', 'SubjectGroupUsersController@store');

Route::get('/subjects/{subject}', 'SubjectsController@show');
Route::patch('/subjects/{subject}', 'SubjectsController@update');
Route::post('/subjects/{subject}', 'SubjectGroupController@store');

Route::get('/subjects/{subject}/{group}', 'SubjectGroupController@index');
Route::patch('/subjects/{subject}/{group}', 'SubjectGroupController@update');
