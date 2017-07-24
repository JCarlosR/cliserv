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

    public function topMatrizHoras()
    {
    	
    }
}
