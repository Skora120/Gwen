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

Route::get('/settings', 'UserController@edit');
Route::patch('/settings', 'UserController@update');

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
            Route::delete('/', 'SubjectGroupController@destroy');
            Route::post('/', 'TaskController@store');
            Route::get('/tasks', 'TaskController@index');

            Route::group(['prefix' => '/{task}'],function() {
            Route::get('/', 'TaskController@show');
            Route::patch('/', 'TaskController@update');
            Route::delete('/', 'TaskController@destroy');
            Route::post('/', 'SubmissionController@store');

                Route::group(['prefix' => '/submissions'],function() {
                    Route::get('/', 'SubmissionController@index');
                    Route::get('/{submission}', 'SubmissionController@show');
                    Route::patch('/{submission}', 'SubmissionController@update');
                    Route::delete('/{submission}', 'SubmissionController@destroy');
                    Route::get('/{submission}/download', 'SubmissionController@download');
                });
            });
        });
    });
});