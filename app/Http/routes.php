<?php

Route::get('/','ClickController@general');
Route::get('general/{inicio}/{fin}','ClickController@general_filtered');
Route::get('tendencia','ClickController@tendencia');
Route::get('tendencia/producto/usuarios','ClickController@tendencia_users');
Route::get('tendencia/producto/categorias','ClickController@tendencia_categories');

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
Route::get('month_year/{year}', 'ClickController@months_year');

// Report JSON Data
Route::get('clicks/all', 'ReportController@all');
Route::get('clicks/user', 'ReportController@byUserType');
Route::get('clicks/device_type', 'ReportController@byDeviceType');
Route::get('clicks/products', 'ReportController@byProducts');
Route::get('clicks/hour', 'ReportController@perHour');
Route::get('clicks/page', 'ReportController@perPages');
Route::get('clicks/categories', 'ReportController@perCategories');
