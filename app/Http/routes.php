<?php

Route::get('/','ClickController@welcome');
Route::get('general/{finicio?}/{ffin?}','ClickController@general');
Route::get('reporte-software','ClickController@software');
Route::get('reporte-web','ClickController@web');
<<<<<<< HEAD
Route::get('reporte-otros','ClickController@other');
=======

// Ramos
Route::get('reporte/horas','ClickController@hours');
Route::get('reporte/trafico','ClickController@traffic');

// Soles
Route::get('reporte-categorias','ClickController@bestCategories');
>>>>>>> d1549cae706b5476847e6aea81808fd59756f4a8

// Report JSON Data
Route::get('clicks/user', 'ReportController@byUserType');
Route::get('clicks/device_type', 'ReportController@byDeviceType');
<<<<<<< HEAD



Route::get('reporte-categorias','CategoryController@bestCategories');
=======
Route::get('clicks/hour', 'ReportController@perHour');
>>>>>>> d1549cae706b5476847e6aea81808fd59756f4a8
