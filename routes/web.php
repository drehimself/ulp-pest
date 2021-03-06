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

Route::get('/postspest', function () {
    return 'hi';
});

Route::get('/', 'PostController@index')->name('posts.index');

Route::get('/posts/create', 'PostController@create')->name('posts.create')->middleware('auth');
Route::post('/posts/create', 'PostController@store')->name('posts.store')->middleware('auth');

Route::get('/posts/{post}', 'PostController@show')->name('posts.show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
