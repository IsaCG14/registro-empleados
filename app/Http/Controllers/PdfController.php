<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PdfController extends Controller
{
    public function getPdf()
    {
        $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->get();
        $centros = \App\Models\Centro::select('nombre_centro', \App\Models\Centro::raw('COUNT(empleados.id) as total'))
            ->join('empleados', 'centros.id', '=', 'empleados.id_centro')
            ->whereNull('empleados.deleted_at')
            ->groupBy('nombre_centro')
            ->get();
        $pdf = PDF::loadView('PDF_Estadisticas', ['empleados' => $empleados, 'centros' => $centros]);
        return $pdf->stream('prueba.pdf');
    }
}