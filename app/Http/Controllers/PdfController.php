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
        $inicio = $request->input('inicio');
        $fin = $request->input('fin');
        $scope = $request->input('scope', 'general');

        // Traer solo lo necesario con el filtro opcional
        $query = Atendidos::with(['personas', 'asuntos.atendidos'])
            ->whereBetween("fecha_atencion", [$inicio, $fin]);

        if ($scope === 'mis_estadisticas') {
            $query->where('id_user', auth()->id());
        }

        $atendidos = $query->get();

        // Conteo eficiente usando filter o sum
        $citas_total = $atendidos->count();

        $citas_masculino = $atendidos->filter(fn($a) => $a->personas->sexo == 1)->count();
        $citas_femenino = $citas_total - $citas_masculino;

        $circuitos = $atendidos->filter(fn($cita) => !empty($cita->personas->consejo_comunal))->count();

        $comunas = $atendidos->filter(fn($cita) => !empty($cita->personas->comuna))->count();

        $sin_especificar = $citas_total - ($circuitos + $comunas);

        //Formatear fechas para el titulo
        $fecha_inicio = DateTime::createFromFormat('Y-m-d', $request['inicio'])->format('d/m/Y');
        $fecha_fin = DateTime::createFromFormat('Y-m-d', $request['fin'])->format('d/m/Y');

        if ($scope === 'mis_estadisticas') {
            $title = 'Mis personas atendidas entre ' . $fecha_inicio . ' y ' . $fecha_fin;
        } else {
            $title = 'Personas atendidas entre ' . $fecha_inicio . ' y ' . $fecha_fin;
        }

        $pdf = PDF::loadView('PDF_Estadisticas', ['datos' => $atendidos, 'title' => $title, 'total' => $citas_total, 'masculino' => $citas_masculino, 'femenino' => $citas_femenino, 'circuitos' => $circuitos, 'comunas' => $comunas, 'sin_especificar' => $sin_especificar]);

        return $pdf->stream('personas.pdf');
    }
}