<?php

Route::group(['prefix' => 'fastleo', 'middleware' => ['web', \Camanru\Fastleo\app\Http\Middleware\CheckAuth::class]], function () {

    // Auth
    Route::match(['get', 'post'], '', 'Camanru\Fastleo\app\Http\Controllers\LoginController@login')->name('fastleo');
    Route::get('/logout', 'Camanru\Fastleo\app\Http\Controllers\LoginController@logout')->name('fastleo.logout');

    // Info
    Route::get('/info', 'Camanru\Fastleo\app\Http\Controllers\InfoController@index')->name('fastleo.info');
    Route::get('/info/clear', 'Camanru\Fastleo\app\Http\Controllers\InfoController@clear')->name('fastleo.info.clear');

    // Log
    Route::get('/log', 'Camanru\Fastleo\app\Http\Controllers\LogController@index')->name('fastleo.log');
    Route::get('/log/clear', 'Camanru\Fastleo\app\Http\Controllers\LogController@clear')->name('fastleo.log.clear');

    // Filemanager
    Route::get('/filemanager', 'Camanru\Fastleo\app\Http\Controllers\FilemanagerController@index')->name('fastleo.filemanager');
    Route::any('/filemanager/create', 'Camanru\Fastleo\app\Http\Controllers\FilemanagerController@create')->name('fastleo.filemanager.create');
    Route::any('/filemanager/uploads', 'Camanru\Fastleo\app\Http\Controllers\FilemanagerController@uploads')->name('fastleo.filemanager.uploads');

    // Models
    Route::get('/app/{model}', 'Camanru\Fastleo\app\Http\Controllers\ModelController@index');
    Route::any('/app/{model}/add', 'Camanru\Fastleo\app\Http\Controllers\ModelController@add');
    Route::get('/app/{model}/menu_on', 'Camanru\Fastleo\app\Http\Controllers\ModelController@menuOn');
    Route::get('/app/{model}/menu_off', 'Camanru\Fastleo\app\Http\Controllers\ModelController@menuOff');
    Route::get('/app/{model}/menu_add', 'Camanru\Fastleo\app\Http\Controllers\ModelController@menuAdd');
    Route::get('/app/{model}/sorting_fix', 'Camanru\Fastleo\app\Http\Controllers\ModelController@sortingFix');
    Route::get('/app/{model}/sorting_add', 'Camanru\Fastleo\app\Http\Controllers\ModelController@sortingAdd');
    Route::get('/app/{model}/rows_export', 'Camanru\Fastleo\app\Http\Controllers\ModelController@rowsExport');
    Route::any('/app/{model}/rows_import', 'Camanru\Fastleo\app\Http\Controllers\ModelController@rowsImport');
    Route::get('/app/{model}/up/{row_id}', 'Camanru\Fastleo\app\Http\Controllers\ModelController@up')->where('row_id', '[0-9]+');
    Route::get('/app/{model}/down/{row_id}', 'Camanru\Fastleo\app\Http\Controllers\ModelController@down')->where('row_id', '[0-9]+');
    Route::get('/app/{model}/menu/{row_id}', 'Camanru\Fastleo\app\Http\Controllers\ModelController@menu')->where('row_id', '[0-9]+');
    Route::any('/app/{model}/edit/{row_id}', 'Camanru\Fastleo\app\Http\Controllers\ModelController@edit')->where('row_id', '[0-9]+');
    Route::get('/app/{model}/delete/{row_id}', 'Camanru\Fastleo\app\Http\Controllers\ModelController@delete')->where('row_id', '[0-9]+');

});