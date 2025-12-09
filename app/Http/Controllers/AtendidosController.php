<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;
use App\Models\Atendidos;

class AtendidosController extends Controller
{
    public function obtener_graficas(Request $request)
    {
        $estados = Estado::all();
        $inicio = $request->input('inicio', date('Y-m-d'));
        $fin = $request->input('fin', date('Y-m-d'));
        $atendidos = Atendidos::with(['personas', 'asuntos.patria', 'usuarios'])->whereBetween('fecha_atencion', [$inicio, $fin])->get();
        return view('grafica', compact('atendidos', 'inicio', 'fin', 'estados'));
    }
}
