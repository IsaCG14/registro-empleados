<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Estado;

class CitaController extends Controller
{
    public function obtener_graficas(Request $request)
    {
        $estados = Estado::all();
        $inicio = $request->input('inicio', date('Y-m-d'));
        $fin = $request->input('fin', date('Y-m-d'));
        $citas = Cita::with(['personas', 'asuntos.patria', 'usuarios'])->whereBetween('fecha_cita', [$inicio, $fin])->get();
        return view('grafica', compact('citas', 'inicio', 'fin', 'estados'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
