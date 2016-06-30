<?php

Route::get('/','ClickController@welcome');
Route::get('general/{finicio?}/{ffin?}','ClickController@general');
Route::get('reporte-software','ClickController@software');
Route::get('reporte-web','ClickController@web');

Route::get('reporte-otros','ClickController@other');


// Ramos
Route::get('reporte/horas','ClickController@hours');
Route::get('reporte/trafico','ClickController@traffic');

// Soles
Route::get('reporte-categorias','CategoryController@bestCategories');
Route::get('month/{year}', 'CategoryController@months_year');
Route::get('reporte-barras/{year?}/{month?}','CategoryController@bestCategoriesData');


// Gonzales
Route::get('reporte/pages', 'ClickController@pages');

// Report JSON Data
Route::get('clicks/user', 'ReportController@byUserType');
Route::get('clicks/device_type', 'ReportController@byDeviceType');

Route::get('clicks/hour', 'ReportController@perHour');

Route::get('clicks/page', 'ReportController@perPages');
