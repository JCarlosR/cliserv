<?php

Route::get('/','ClickController@general');
Route::get('general/{finicio?}/{ffin?}','ClickController@general');

Route::get('reporte-otros','ClickController@other');
Route::get('reporte-top10','ClickController@products');

// General
Route::get('reporte/data-mining', 'DataController@mining');

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
Route::get('clicks/all', 'ReportController@all');
Route::get('clicks/user', 'ReportController@byUserType');
Route::get('clicks/device_type', 'ReportController@byDeviceType');
Route::get('clicks/products', 'ReportController@byProducts');
Route::get('clicks/hour', 'ReportController@perHour');
Route::get('clicks/page', 'ReportController@perPages');
