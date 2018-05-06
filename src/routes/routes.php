<?php

Route::middleware(['web', Camanru\Fastleo\CheckAuth::class])->group(function () {

    // Auth
    Route::match(['get', 'post'], '/fastleo', 'Camanru\Fastleo\LoginController@login');
    Route::get('/fastleo/logout', 'Camanru\Fastleo\LoginController@logout')->name('fastleo.logout');

    // Config
    Route::get('/fastleo/config', 'Camanru\Fastleo\ConfigController@index')->name('fastleo.config');

    // Info
    Route::get('/fastleo/info', 'Camanru\Fastleo\InfoController@index')->name('fastleo.info');

    // Pages
    Route::get('/fastleo/pages', 'Camanru\Fastleo\PagesController@index')->name('fastleo.pages');

    // Users
    Route::get('/fastleo/users', 'Camanru\Fastleo\UsersController@index')->name('fastleo.users');
    Route::get('/fastleo/users/create', 'Camanru\Fastleo\UsersController@create')->name('fastleo.users.create');
    Route::get('/fastleo/users/edit/{user_id}', 'Camanru\Fastleo\UsersController@edit')->where('user_id', '[0-9]+')->name('fastleo.users.edit');
    Route::post('/fastleo/users/save/{user_id?}', 'Camanru\Fastleo\UsersController@save')->where('user_id', '[0-9]+')->name('fastleo.users.save');
});