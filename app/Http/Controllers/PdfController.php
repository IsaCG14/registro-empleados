<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use DateTime;

class PdfController extends Controller
{
    public function getPdf(Request $request)
    {
        //$centro = \App\Models\Empleado::join('centros', 'empleados.id_centro', '=', 'centros.id')->select('centros.*')->get();
        $centros = \App\Models\Centro::all();
        $carnets = \App\Models\Carnet::all();
        $areas = \App\Models\Area::all();

        switch ($request['tipo']) {
            case 1:
                //Reporte por centro
                $centro = \App\Models\Centro::select('nombre_centro')->where("id", $request['centro'])->first();
                $title = ' que votan en ' . $centro->nombre_centro;
                $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->where('id_centro', $request['centro'])->get();
                break;
            case 2:
                //Reporte por sexo
                $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->where('sexo', $request['sexo'])->get();
                $title = ' de sexo ' . $request['sexo'];
                break;
            case 3:
                //Reporte por contrato
                if ($request['tipo_empleado'] == 0) {
                    $title = " Contratados";
                } else if ($request['tipo_empleado'] == 1) {
                    $title = " Trabajando fijo";
                } else if ($request['tipo_empleado'] == 2) {
                    $title = " Pasantes";
                } else {
                    $title = " Jubilados";
                }
                $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->where('tipo', $request['tipo_empleado'])->get();
                break;
            case 4:
                //Reporte por fecha de ingreso
                $fecha = new DateTime($request['fecha_ingreso']);
                $title = ' que ingresaron hasta ' . $fecha->format("d/m/Y");
                $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->where('fecha_ingreso', '<=', $request['fecha_ingreso'])->get();
                break;
            case 5:
                //Reporte por area
                $area = \App\Models\Area::select('oficina')->where("id", $request['area'])->first();
                $title = ' de ' . $area->oficina;
                $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->where('area', $request['area'])->get();
                break;
            default:
                //Reporte general
                $title = " registrados";
                $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->get();
                break;
        }

        //Establecer columnas
        $atributos = $request->input('atributos', []);

        $hijos = null;
        if (in_array('hijos', $atributos)) {
            $hijos = \App\Models\Hijo::join('personas', 'hijos.id_persona', '=', 'personas.id')->select('hijos.*', 'hijos.id AS id_hijo', 'personas.*')->get();
            $pdf = PDF::loadView('PDF_Hijos', ['empleados' => $empleados, 'title' => $title, 'atributos' => $request['atributos'], 'centros' => $centros, 'carnets' => $carnets, 'areas' => $areas, 'hijos' => $hijos]);
        } else {
            $pdf = PDF::loadView('PDF_Estadisticas', ['empleados' => $empleados, 'title' => $title, 'atributos' => $request['atributos'], 'centros' => $centros, 'carnets' => $carnets, 'areas' => $areas]);
        }

        return $pdf->stream('empleados.pdf');
    }
}