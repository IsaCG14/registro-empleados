<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atendidos;
use App\Models\Parroquia;
use App\Models\Municipio;
use App\Models\Estado;
use App\Models\Patria;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PersonaExport;
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
            ->whereBetween("fecha_atencion", [$inicio, $fin])
            ->filtros($request);

        if ($scope === 'mis_estadisticas') {
            $query->where('id_user', auth()->id());
        } else if ($scope === 'excel') {
            return Excel::download(new PersonaExport($inicio, $fin, $request), 'atendidos.ods', \Maatwebsite\Excel\Excel::ODS);
        }

        $atendidos = $query->get();

        //Conteo asuntos atendidos
        $asuntos = [];
        foreach ($atendidos as $atendido) {
            foreach ($atendido->asuntos as $asunto) {
                $asuntoNombre = $asunto->patria ? $asunto->patria->opciones : 'Sin especificar';
                if (!isset($asuntos[$asuntoNombre])) {
                    $asuntos[$asuntoNombre] = 0;
                }
                $asuntos[$asuntoNombre]++;
            }
        }

        // Conteo eficiente usando filter o sum
        $citas_total = $atendidos->count();

        $sin_sexo = $atendidos->filter(fn($a) => $a->personas->sexo === null)->count();
        $citas_masculino = $atendidos->filter(fn($a) => $a->personas->sexo == 1)->count();
        $citas_femenino = $atendidos->filter(fn($a) => $a->personas->sexo == 0)->count();

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

        //Descripción de los filtros aplicados
        $filtros = $this->descripcionFiltros($request);

        $pdf = PDF::loadView('PDF_Estadisticas', ['datos' => $atendidos, 'asuntos' => $asuntos, 'title' => $title, 'total' => $citas_total, 'masculino' => $citas_masculino, 'femenino' => $citas_femenino, 'sin_sexo' => $sin_sexo, 'circuitos' => $circuitos, 'comunas' => $comunas, 'sin_especificar' => $sin_especificar, 'filtros' => $filtros]);

        return $pdf->stream('personas.pdf');
    }

    private function descripcionFiltros(Request $request): array
    {
        $filtros = [];

        $sexo = $request->input('sexo');
        if ($sexo !== null && $sexo !== '') {
            $filtros[] = 'Sexo: ' . ($sexo == 1 ? 'Masculino' : 'Femenino');
        }

        $parroquia_id = $request->input('parroquia');
        $municipio_id = $request->input('municipio');
        $estado_id = $request->input('estado');

        if ($parroquia_id) {
            $parroquia = Parroquia::find($parroquia_id);
            $filtros[] = 'Parroquia: ' . ($parroquia?->parroquia ?: 'Sin especificar');
            $municipio_id = $parroquia?->id_municipio;
        }
        if ($municipio_id) {
            $municipio = Municipio::find($municipio_id);
            $filtros[] = 'Municipio: ' . ($municipio?->municipio ?: 'Sin especificar');
            $estado_id = $municipio?->id_estado;
        }
        if ($estado_id) {
            $estado = Estado::find($estado_id);
            $filtros[] = 'Estado: ' . ($estado?->estado ?: 'Sin especificar');
        }

        $asunto_id = $request->input('asunto');
        if ($asunto_id) {
            $patria = Patria::find($asunto_id);
            $filtros[] = 'Asunto: ' . ($patria?->opciones ?: 'Sin especificar');
        }

        $comunidad = $request->input('comunidad');
        if ($comunidad) {
            $filtros[] = match ($comunidad) {
                'comuna' => 'Comunidad: Comuna',
                'circuito' => 'Comunidad: Circuito Comunal',
                'sin_especificar' => 'Comunidad: Sin especificar',
                default => 'Comunidad: ' . $comunidad,
            };
        }

        return $filtros;
    }

    // public function getExcel()
    // {
    //     // return Excel::download(new PersonaExport, 'personas.xlsx');
    // }
}