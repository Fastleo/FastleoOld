<?php

$middlewares = [
    'web',
    Camanru\Fastleo\CheckAuth::class,
    Camanru\Fastleo\ModelsList::class
];

Route::middleware($middlewares)->group(function () {

    // Auth
    Route::match(['get', 'post'], '/fastleo', 'Camanru\Fastleo\LoginController@login')->name('fastleo');
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

    // Models
    Route::get('/fastleo/app/{model}', 'Camanru\Fastleo\ModelController@index');
    Route::get('/fastleo/app/{model}/add', 'Camanru\Fastleo\ModelController@add');
    Route::get('/fastleo/app/{model}/edit/{row_id}', 'Camanru\Fastleo\ModelController@edit')->where('row_id', '[0-9]+');
    Route::get('/fastleo/app/{model}/delete/{row_id}', 'Camanru\Fastleo\ModelController@delete')->where('row_id', '[0-9]+');
    Route::post('/fastleo/app/{model}/save/{row_id}', 'Camanru\Fastleo\ModelController@save')->where('row_id', '[0-9]+');
});