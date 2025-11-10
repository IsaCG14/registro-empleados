<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Parroquia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use DateTime;

class PdfController extends Controller
{
    public function getPdf(Request $request)
    {
        $citas = Cita::with('personas', 'patria', 'usuarios','personas.parroquia.municipio.estado')->whereBetween("fecha_cita", [$request['inicio'], $request['fin']])->get();

        $title = 'Citas registradas entre ' . $request['inicio'] . ' y ' . $request['fin'];

        $pdf = PDF::loadView('PDF_Estadisticas', ['datos' => $citas, 'title' => $title]);

        return $pdf->stream('personas.pdf');
    }
}