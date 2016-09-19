<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'TaskController@home')->name('tasks');
Route::get('task/new/{id}', 'TaskController@newTask')->name('move_to_new_task');
Route::get('task/in_progress/{id}', 'TaskController@inProgressTask')->name('move_to_in_progress_task');
Route::get('task/complete/{id}', 'TaskController@completeTask')->name('move_to_complete_task');
Route::get('task/delete/{id}', 'TaskController@deleteTask')->name('delete_task');
Route::post('task/new', 'TaskController@create')->name('add_new_task');