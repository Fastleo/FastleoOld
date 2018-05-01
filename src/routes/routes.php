<?php

Route::middleware(['web', Camanru\Fastleo\CheckAuth::class])->group(function () {
    Route::match(['get', 'post'], '/fastleo', 'Camanru\Fastleo\LoginController@login');
    Route::get('/fastleo/logout', 'Camanru\Fastleo\LoginController@logout');
    Route::get('/fastleo/config', 'Camanru\Fastleo\ConfigController@index');
    Route::get('/fastleo/info', 'Camanru\Fastleo\InfoController@index');
    Route::get('/fastleo/pages', 'Camanru\Fastleo\PagesController@index');
    Route::get('/fastleo/users', 'Camanru\Fastleo\UsersController@index');
});