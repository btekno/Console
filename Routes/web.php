<?php

Route::as('console.')->group(function() 
{
    Route::get('/', 'IndexController@index')->name('index');

    


    Route::namespace('Komix')->as('komix.')->prefix('komix')->group(function() {
        Route::get('/', 'IndexController@index')->name('index');

    });

    Route::namespace('Today')->as('today.')->prefix('today')->group(function() {
        Route::get('/', 'IndexController@index')->name('index');
        
    });
});
