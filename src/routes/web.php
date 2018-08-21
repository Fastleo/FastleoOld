<?php

Route::group(['prefix' => 'fastleo', 'middleware' => ['web', Camanru\Fastleo\CheckAuth::class]], function () {

    // Auth
    Route::match(['get', 'post'], '', 'Camanru\Fastleo\LoginController@login')->name('fastleo');
    Route::get('/logout', 'Camanru\Fastleo\LoginController@logout')->name('fastleo.logout');

    // Info
    Route::get('/info', 'Camanru\Fastleo\InfoController@index')->name('fastleo.info');
    Route::get('/info/clear', 'Camanru\Fastleo\InfoController@clear')->name('fastleo.info.clear');

    // Log
    Route::get('/log', 'Camanru\Fastleo\LogController@index')->name('fastleo.log');
    Route::get('/log/clear', 'Camanru\Fastleo\LogController@clear')->name('fastleo.log.clear');

    // Filemanager
    Route::get('/filemanager', 'Camanru\Fastleo\FilemanagerController@index')->name('fastleo.filemanager');
    Route::any('/filemanager/create', 'Camanru\Fastleo\FilemanagerController@create')->name('fastleo.filemanager.create');
    Route::any('/filemanager/uploads', 'Camanru\Fastleo\FilemanagerController@uploads')->name('fastleo.filemanager.uploads');

    // Models
    Route::get('/app/{model}', 'Camanru\Fastleo\ModelController@index');
    Route::any('/app/{model}/add', 'Camanru\Fastleo\ModelController@add');
    Route::get('/app/{model}/menu_on', 'Camanru\Fastleo\ModelController@menuOn');
    Route::get('/app/{model}/menu_off', 'Camanru\Fastleo\ModelController@menuOff');
    Route::get('/app/{model}/menu_add', 'Camanru\Fastleo\ModelController@menuAdd');
    Route::get('/app/{model}/sorting_fix', 'Camanru\Fastleo\ModelController@sortingFix');
    Route::get('/app/{model}/sorting_add', 'Camanru\Fastleo\ModelController@sortingAdd');
    Route::get('/app/{model}/rows_export', 'Camanru\Fastleo\ModelController@rowsExport');
    Route::any('/app/{model}/rows_import', 'Camanru\Fastleo\ModelController@rowsImport');
    Route::get('/app/{model}/up/{row_id}', 'Camanru\Fastleo\ModelController@up')->where('row_id', '[0-9]+');
    Route::get('/app/{model}/down/{row_id}', 'Camanru\Fastleo\ModelController@down')->where('row_id', '[0-9]+');
    Route::get('/app/{model}/menu/{row_id}', 'Camanru\Fastleo\ModelController@menu')->where('row_id', '[0-9]+');
    Route::any('/app/{model}/edit/{row_id}', 'Camanru\Fastleo\ModelController@edit')->where('row_id', '[0-9]+');
    Route::get('/app/{model}/delete/{row_id}', 'Camanru\Fastleo\ModelController@delete')->where('row_id', '[0-9]+');

});