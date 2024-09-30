<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Hijo extends Controller
{
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
        \App\Models\Persona::create([
            'nombre' => $request['nombre'],
            'sexo' => $request['sexo'],
            'fecha_nacimiento' => $request['edad'],
            'estudiante' => $request['estudiante']
        ]);

        $id_hijo = \App\Models\Persona::select('id')->latest()->first();
        \App\Models\Hijo::create([
            'id_persona' => $id_hijo->id,
            'id_empleado' => $request['id_empleado']
        ]);

        return response()->json(['id_hijo' => $id_hijo]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hijos = \App\Models\Hijo::join('personas', 'hijos.id_persona', '=', 'personas.id')->select('personas.*')->where('hijos.id_empleado', $id)->get();
        return response()->json($hijos);
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
        $persona = \App\Models\Persona::find($id);
        $persona->delete();

        $hijo = \App\Models\Hijo::where("id_persona", $id);
        $hijo->delete();
    }
}