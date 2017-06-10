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

Route::get('/threads', 'ThreadsController@index')->name('allThreads');
Route::get('/threads/create', 'ThreadsController@create')->name('createThread');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('add_reply_to_thread');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
