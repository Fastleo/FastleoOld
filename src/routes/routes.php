<?php

Route::get('/fastleo/', 'Camanru\Fastleo\LoginController@login');
Route::get('/fastleo/login', 'Camanru\Fastleo\LoginController@login');

Route::get('/fastleo/config', 'Camanru\Fastleo\ConfigController@index');
Route::get('/fastleo/info', 'Camanru\Fastleo\InfoController@index');
Route::get('/fastleo/pages', 'Camanru\Fastleo\PagesController@index');
Route::get('/fastleo/users', 'Camanru\Fastleo\UsersController@index');