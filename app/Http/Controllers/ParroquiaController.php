<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parroquia;

class ParroquiaController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $parroquias = Parroquia::where('id_municipio', $id)->get();
        return response()->json($parroquias);
    }

    public function obtener_ubicacion(string $id)
    {
        $parroquia = Parroquia::select('parroquia')->find($id);
        return $parroquia;
    }

    public function obtener_ubicacion_completa(string $id)
    {
        $parroquia = Parroquia::with('municipio.estado')->find($id);
        return $parroquia;
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
