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


Route::group(['prefix' => '/subjects'],function() {
    Route::get('/', 'SubjectsController@index');
    Route::post('/', 'SubjectsController@store');

    Route::post('/join_group', 'SubjectGroupUsersController@store')->name('subject-join');

    Route::group(['prefix' => '/{subject}'],function() {
        Route::get('/', 'SubjectsController@show');
        Route::patch('/', 'SubjectsController@update');
        Route::post('/', 'SubjectGroupController@store');

        Route::group(['prefix' => '/{group}'],function() {
            Route::get('/', 'SubjectGroupController@show');
            Route::patch('/', 'SubjectGroupController@update');
            Route::post('/', 'TaskController@store');
            Route::get('/tasks', 'TaskController@index');
            
            Route::get('/{task}', 'TaskController@show');
            Route::patch('/{task}', 'TaskController@update');

            Route::post('/{task}', 'SubmissionController@store');
//            Route::get('/{task}/', 'SubmissionController@index');
            Route::get('/{task}/{submission}', 'SubmissionController@show');
            Route::patch('/{task}/{submission}', 'SubmissionController@update');
            Route::get('/{task}/{submission}/download', 'SubmissionController@download');
        });
    });
});