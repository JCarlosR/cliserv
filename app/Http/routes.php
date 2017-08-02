<?php

Route::get('/','ClickController@general');
Route::get('general/{inicio}/{fin}','ClickController@general_filtered');
Route::get('tendencia','ClickController@tendencia');
Route::get('tendencia/producto/usuarios','ClickController@tendencia_users');
Route::get('tendencia/categorias/usuarios','ClickController@tendencia_categories');

Route::get('reporte-otros','ClickController@other');
Route::get('reporte-top10','ClickController@products');
Route::get('metas','ClickController@metas');
Route::get('get_metas/{grade}/{phone}','ClickController@update_metas');

// General
Route::get('reporte/data-mining', 'DataController@mining');

// R
Route::get('prestashop/products', 'PrestashopController@index');

Route::get('excel/top/productos', 'ExcelController@topProductos');
Route::get('excel/top/matriz', 'ExcelController@topMatrizHoras');
Route::get('pdf/top/productos', 'PdfController@topProductos');
Route::get('pdf/top/matriz', 'PdfController@topMatrizHoras');

Route::get('top/productos','TopController@clicksAndPercentage');
Route::get('top/productos/data', 'TopController@productTopData');
Route::get('top/horas/data', 'TopController@peakHoursData');

Route::get('top/matriz','TopController@matrix');
Route::get('top/horas/matriz', 'TopController@peakHoursMatrix');

Route::get('reporte/horas','ClickController@hours');
Route::get('reporte/trafico','ClickController@traffic');

// S
Route::get('reporte-categorias','CategoryController@bestCategories');
Route::get('month/{year}', 'CategoryController@months_year');
Route::get('reporte-barras/{year?}/{month?}','CategoryController@bestCategoriesData');

// G
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
