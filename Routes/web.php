<?php

Route::as('console::')->group(function() 
{
    Route::get('/', 'IndexController@index')->name('index');
    Route::resource('members', 'MemberController');

    Route::namespace('Komix')->as('komix.')->prefix('komix')->group(function() {
        Route::get('/', 'IndexController@index')->name('index');

    });

    Route::namespace('Today')->as('today.')->prefix('today')->group(function() {
        Route::get('/', 'IndexController@index')->name('index');
        
        Route::resource('posts', 'PostController');
        Route::resource('kategori', 'Kategori\\IndexController');
        Route::resource('kategori.posts', 'Kategori\\PostController');

        Route::resource('reaksi', 'ReaksiController');
        Route::resource('widget', 'WidgetController');
        Route::resource('laman', 'LamanController');
        Route::resource('member', 'MemberController');
        
        Route::resource('pengaturan', 'PengaturanController')->only(['index', 'store']);
    });

    Route::namespace('Kamus')->as('kamus.')->prefix('kamus')->group(function() {
        Route::get('/', 'IndexController@index')->name('index');
        
    });
});