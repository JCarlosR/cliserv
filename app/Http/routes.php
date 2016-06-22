<?php

Route::get('/','ClickController@welcome');
Route::get('general/{finicio?}/{ffin?}','ClickController@general');
Route::get('reporte-software','ClickController@software');
Route::get('reporte-web','ClickController@web');
Route::get('reporte-otros','ClickController@other');

// Report JSON Data
Route::get('clicks/user', 'ReportController@byUserType');