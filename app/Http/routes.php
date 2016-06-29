<?php

Route::get('/','ClickController@welcome');
Route::get('general/{finicio?}/{ffin?}','ClickController@general');
Route::get('reporte-software','ClickController@software');
Route::get('reporte-web','ClickController@web');

// Ramos
Route::get('reporte/horas','ClickController@hours');
Route::get('reporte/trafico','ClickController@traffic');

// Soles
Route::get('reporte-categorias','ClickController@bestCategories');

// Report JSON Data
Route::get('clicks/user', 'ReportController@byUserType');
Route::get('clicks/device_type', 'ReportController@byDeviceType');
Route::get('clicks/hour', 'ReportController@perHour');
