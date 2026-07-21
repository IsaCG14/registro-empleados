<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;
use App\Models\Atendidos;
use App\Models\Cita;

class AtendidosController extends Controller
{
    public function obtener_graficas(Request $request)
    {
        $estados = Estado::all();
        $inicio = $request->input('inicio', date('Y-m-d'));
        $fin = $request->input('fin', date('Y-m-d'));
        $ver = $request->input('ver', 'general');
        $id_usuario = auth()->user()->id; 

        $queryAtendidos = Atendidos::with(['personas', 'asuntos.patria', 'usuarios'])->whereBetween('fecha_atencion', [$inicio, $fin]);
        $queryCitas = Cita::whereBetween('fecha_cita', [$inicio, $fin]);

        if ($ver === 'mis-estadisticas') {
            $queryAtendidos->where('id_user', $id_usuario);
            $queryCitas->whereHas('atendidos', function ($query) use ($id_usuario) {
                $query->where('id_user', $id_usuario);
            });
        }

        $atendidos = $queryAtendidos->get();
        $citas = $queryCitas->get();

        $citas_total = $atendidos->count();

        $circuitos = $atendidos->filter(fn($cita) => !empty($cita->consejo_comunal))->count();
        $comunas = $atendidos->filter(fn($cita) => !empty($cita->comuna))->count();

        $sin_especificar = $citas_total - ($circuitos + $comunas);

        return view('grafica', compact('atendidos', 'inicio', 'fin', 'estados', 'citas', 'circuitos', 'comunas', 'sin_especificar', 'id_usuario'));
    }
}