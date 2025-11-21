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
        $citas = Cita::with('personas', 'asuntos.patria', 'usuarios','personas.parroquia.municipio.estado')->whereBetween("fecha_cita", [$request['inicio'], $request['fin']])->get();

        //Sacar total personas y total por sexo
        $citas_total = $citas->count();
        $citas_masculino = $citas->where('personas.sexo', '1')->count();
        $citas_femenino = $citas->where('personas.sexo', '0')->count();

        $title = 'Citas registradas entre ' . $request['inicio'] . ' y ' . $request['fin'];

        $pdf = PDF::loadView('PDF_Estadisticas', ['datos' => $citas, 'title' => $title, 'total' => $citas_total, 'masculino' => $citas_masculino, 'femenino' => $citas_femenino]);

        return $pdf->stream('personas.pdf');
    }
}