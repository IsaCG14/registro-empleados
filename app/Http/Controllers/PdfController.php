<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atendidos;
use App\Models\Parroquia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use DateTime;

class PdfController extends Controller
{
    public function getPdf(Request $request)
    {
        $atendidos = Atendidos::with('personas', 'asuntos.patria', 'usuarios','personas.parroquia.municipio.estado')->whereBetween("fecha_atencion", [$request['inicio'], $request['fin']])->orderBy('fecha_atencion', 'asc')->get();

        //Sacar total personas y total por sexo
        $citas_total = $atendidos->count();
        $citas_masculino = $atendidos->where('personas.sexo', '1')->count();
        $citas_femenino = $atendidos->where('personas.sexo', '0')->count();

        //Formatear fechas para el titulo
        $fecha_inicio = DateTime::createFromFormat('Y-m-d', $request['inicio'])->format('d/m/Y');
        $fecha_fin = DateTime::createFromFormat('Y-m-d', $request['fin'])->format('d/m/Y');

        $title = 'Personas atendidas entre ' . $fecha_inicio . ' y ' . $fecha_fin;

        $pdf = PDF::loadView('PDF_Estadisticas', ['datos' => $atendidos, 'title' => $title, 'total' => $citas_total, 'masculino' => $citas_masculino, 'femenino' => $citas_femenino]);

        return $pdf->stream('personas.pdf');
    }
}