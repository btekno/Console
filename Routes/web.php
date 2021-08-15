<?php

Route::as('console.')->group(function() {
    Route::get('/', 'IndexController@index')->name('index');
});
