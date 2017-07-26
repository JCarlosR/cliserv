<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

use App\Http\Requests;

class PdfController extends Controller
{
    public function topProductos(Request $request, PDF $pdf)
    {
        $topController = new TopController();
        $data = $topController->productTopData($request);

        $pdf = $pdf->loadView('reports.products.top-pdf', $data);
        return $pdf->download('Top productos.pdf');
    }
/*
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
    }*/
}
