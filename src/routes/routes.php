<?php

Route::middleware(['web', Camanru\Fastleo\CheckAuth::class])->group(function () {

    // Auth
    Route::match(['get', 'post'], '/fastleo', 'Camanru\Fastleo\LoginController@login')->name('fastleo');
    Route::get('/fastleo/logout', 'Camanru\Fastleo\LoginController@logout')->name('fastleo.logout');

    // Info
    Route::get('/fastleo/info', 'Camanru\Fastleo\InfoController@index');

    // Models
    Route::get('/fastleo/app/{model}', 'Camanru\Fastleo\ModelController@index');
    Route::any('/fastleo/app/{model}/add', 'Camanru\Fastleo\ModelController@add');
    Route::get('/fastleo/app/{model}/menu/{row_id}', 'Camanru\Fastleo\ModelController@menu')->where('row_id', '[0-9]+');
    Route::any('/fastleo/app/{model}/edit/{row_id}', 'Camanru\Fastleo\ModelController@edit')->where('row_id', '[0-9]+');
    Route::get('/fastleo/app/{model}/delete/{row_id}', 'Camanru\Fastleo\ModelController@delete')->where('row_id', '[0-9]+');

    // Filemanager
    Route::get('/fastleo/filemanager', 'Camanru\Fastleo\FilemanagerController@index');
    Route::any('/fastleo/filemanager/create', 'Camanru\Fastleo\FilemanagerController@create');
    Route::any('/fastleo/filemanager/uploads', 'Camanru\Fastleo\FilemanagerController@uploads');
    
});