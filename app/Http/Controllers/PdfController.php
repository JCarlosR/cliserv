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

    public function topMatrizHoras(Request $request, PDF $pdf)
    {
        $topController = new TopController();
        $matrix = $topController->peakHoursMatrix($request);

        $pdf = $pdf->loadView('reports.products.matrix-pdf', compact('matrix'));
        return $pdf->download('Matriz de horas pico.pdf');
    }
}
