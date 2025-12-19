<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Atendidos;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inicio = $request->input('inicio', date('Y-m-d'));
        $fin = $request->input('fin', date('Y-m-d'));
        $query = Cita::with('atendidos.personas', 'atendidos.asuntos.patria')->whereBetween('fecha_cita', [$inicio, $fin]);
        $citas = $query->paginate(10);
        return view('citas', compact(['citas', 'inicio', 'fin']));
    }

    public function create()
    {
        $asunto = Atendidos::with('personas', 'asuntos.patria', 'usuarios')->find(request()->route('id'));
        $citas = Cita::all(); 
        return view('calendario', compact(['citas', 'asunto']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Comprobar si ya el asunto tiene una cita agendada
        $citaExistente = Cita::where('id_atencion', $request->input('id_atencion'))->first();
        if($citaExistente) {
            //Reagendar la cita
            $citaExistente->fecha_cita = $request->input('fecha_cita');
            $citaExistente->hora_cita = $request->input('hora_cita');
            $citaExistente->status = 'Reagendada';
            $citaExistente->save();
            session()->flash('success_alert', '¡Cita reagendada exitosamente!');
            return redirect()->route('citas');
        } else {
            Cita::create([
                'fecha_cita' => $request->input('fecha_cita'),
                'hora_cita' => $request->input('hora_cita'),
                'id_atencion' => $request->input('id_atencion'),
                'status' => 'Pendiente',
            ]);
            session()->flash('success_alert', '¡Cita agendada exitosamente!');
            return redirect()->route('citas');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $fecha)
    {
        //Obtener las citas de la fecha dada
        $citas = Cita::with('atendidos.personas', 'atendidos.asuntos.patria')->where('fecha_cita', $fecha)->get();
        return response()->json($citas);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cita = Cita::find($id);
        $cita->status = 'Atendida';
        $cita->save();
        session()->flash('success_alert', '¡Cita marcada como atendida exitosamente!');
        return redirect()->route('citas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cita::destroy($id);
        session()->flash('success_alert', '¡Cita cancelada exitosamente!');
        return redirect()->route('citas');
    }
}