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

Route::get('/', 'ProjectsController@index');

Auth::routes();

Route::get('/home', 'ProjectsController@index')->name('home');
Route::resource('/projects', 'ProjectsController');
Route::resource('/tasks', 'TasksController');
Route::post('/tasks/done/{id}', 'TasksController@changeDoneStatus');
Route::post('/tasks/order', 'TasksController@changeOrder');
Route::post('/tasks/deadline', 'TasksController@changeDeadline');