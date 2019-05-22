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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => '/admin'],function() {
    Route::get('/', 'Admin\AdminController@index');

    Route::get('/users/{user}', 'Admin\AdminUsersController@show');
    Route::patch('/users/{user}', 'Admin\AdminUsersController@update');
    Route::get('/users/{user}/submissions', 'Admin\AdminSubmissionsController@index');
    Route::get('/users', 'Admin\AdminUsersController@index');

    Route::get('/subjects', 'Admin\AdminSubjectsController@index');

});

Route::group(['prefix' => '/statistics'],function() {
    Route::get('/', 'StatisticsController@index');
    Route::get('/subjects/{subject}', 'StatisticsLecturerController@subject_show');
    Route::get('/subjects/{subject}/{group}', 'StatisticsLecturerController@group_show');
});


Route::get('/settings', 'UserController@edit');
Route::patch('/settings', 'UserController@update');

Route::group(['prefix' => '/subjects'],function() {
    Route::get('/', 'SubjectsController@index');
    Route::post('/', 'SubjectsController@store');

    Route::post('/join_group', 'SubjectGroupUsersController@store')->name('subject-join');

    Route::group(['prefix' => '/{subject}'],function() {
        Route::get('/', 'SubjectsController@show');
        Route::patch('/', 'SubjectsController@update');
        Route::delete('/', 'SubjectsController@destroy');

        Route::post('/', 'SubjectGroupController@store');
        Route::post('/task', 'TaskController@store_multiple');

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

Route::get('/test', function(){
	return view('test');
});

Route::get('/test_send_task', function(){
	return view('test_send_task');
});