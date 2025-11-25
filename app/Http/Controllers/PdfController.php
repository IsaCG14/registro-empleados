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
        $citas = Cita::with('personas', 'asuntos.patria', 'usuarios','personas.parroquia.municipio.estado')->whereBetween("fecha_cita", [$request['inicio'], $request['fin']])->orderBy('fecha_cita', 'asc')->get();

        //Sacar total personas y total por sexo
        $citas_total = $citas->count();
        $citas_masculino = $citas->where('personas.sexo', '1')->count();
        $citas_femenino = $citas->where('personas.sexo', '0')->count();

        //Formatear fechas para el titulo
        $fecha_inicio = DateTime::createFromFormat('Y-m-d', $request['inicio'])->format('d/m/Y');
        $fecha_fin = DateTime::createFromFormat('Y-m-d', $request['fin'])->format('d/m/Y');

        $title = 'Citas registradas entre ' . $fecha_inicio . ' y ' . $fecha_fin;

        $pdf = PDF::loadView('PDF_Estadisticas', ['datos' => $citas, 'title' => $title, 'total' => $citas_total, 'masculino' => $citas_masculino, 'femenino' => $citas_femenino]);

        return $pdf->stream('personas.pdf');
    }
}