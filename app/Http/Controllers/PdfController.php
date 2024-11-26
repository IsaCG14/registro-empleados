<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use DateTime;

class PdfController extends Controller
{
    public function getPdf(Request $request)
    {
        //Reporte de todos los empleados
        if (empty($request->all())) {
            $title = " registrados";
            $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->get();
        }
        switch ($request['tipo']) {
            case 1:
                //Reporte por area
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
        }

        $pdf = PDF::loadView('PDF_Estadisticas', ['empleados' => $empleados, 'title' => $title]);
        return $pdf->stream('empleados.pdf');
    }
}
