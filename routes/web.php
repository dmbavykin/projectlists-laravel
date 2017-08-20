<?php

Route::get('/', function() { return redirect('/home'); });

Auth::routes();

Route::get('/home', 'ProjectsController@index')->name('home');
Route::resource('/projects', 'ProjectsController');
Route::resource('/tasks', 'TasksController');
Route::post('/tasks/done/{id}', 'TasksController@changeDoneStatus');
Route::post('/tasks/order', 'TasksController@changeOrder');
Route::post('/tasks/deadline', 'TasksController@changeDeadline');