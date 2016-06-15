<?php

Route::get('/{finicio?}/{ffin?}','ClickController@general');
Route::get('/reporte-software','ClickController@software');
Route::get('/reporte-web','ClickController@web');
Route::get('/reporte-otros','ClickController@other');