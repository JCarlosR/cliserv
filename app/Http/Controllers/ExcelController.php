<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Excel;

class ExcelController extends Controller
{
    public function topProductos(Request $request)
    {
    	$topController = new TopController();
    	$data = $topController->productTopData($request);

    	Excel::create('Top productos', function($excel) use ($data) {
		    $excel->sheet('Top productos', function($sheet) use ($data) {

	        	$sheet->appendRow(['Producto', 'Cantidad', 'Porcentaje (%)']);

		        foreach ($data['pairs'] as $product) {
		        	$sheet->appendRow([
		                $product['product'], $product['quantity'], $product['percent']
		            ]);
		        }

		    });
		})->export('xls');
    }

    public function topMatrizHoras(Request $request)
    {
        $topController = new TopController();
        $data = $topController->peakHoursMatrix($request);

        Excel::create('Matriz de horas pico', function($excel) use ($data) {
            $excel->sheet('Matriz de horas pico', function($sheet) use ($data) {

                $sheet->appendRow([
                    'Hora', 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'
                ]);

                for ($h=0; $h<24; ++$h) {
                    $newRow = [];
                    $newRow[] = $h . ' - ' . ($h+1);
                    for ($d=0; $d<7; ++$d) {
                        $cell = $data[$d][$h];
                        $quantity = $cell['q'];
                        $percentage = $cell['p'];

                        $newRow[] = $quantity . '(' . $percentage . ')';
                    }
                    $sheet->appendRow($newRow);
                }

            });
        })->export('xls');    	
    }
}
