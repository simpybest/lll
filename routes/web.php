<?php


use Illuminate\Support\Facades\Route;

Route::get('/', 'PostController@index');

Route::resource('/post','PostController');
Route::get('/user', 'PostController@user');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
