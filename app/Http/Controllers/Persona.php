<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estado;
use App\Models\Patria;
use App\Models\Atendidos;
use App\Models\User; 
use App\Models\Municipio; 
use App\Models\Parroquia; 
use App\Models\Asunto; 

class Persona extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');

        $query = Atendidos::with(['personas', 'asuntos.patria', 'usuarios'])->orderBy('fecha_atencion', 'desc');

        if($busqueda) {
            $query->whereHas('personas', function ($q) use ($busqueda) {
            // Buscar la cadena en la cédula O el nombre de la persona
                $q->where('cedula', 'like', '%' . $busqueda . '%')->orWhere('nombre', 'like', '%' . $busqueda . '%');
          });
        }

        $atendidos = $query->paginate(10);
        
        return view('index', compact('atendidos'));
    }

    public function create()
    {
        $estados = Estado::all();
        $asuntos = Patria::all();
        return view("form", compact(["estados", "asuntos"]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Validar si la persona con dicha cedula ya esta registrada
        $persona = \App\Models\Persona::where('cedula', $request['cedula'])->first();
        if(!$persona) {
            \App\Models\Persona::create([
                'cedula' => $request['cedula'],
                'nombre' => $request['nombre'],
                'fecha_nacimiento' => $request['fecha_nacimiento'],
                'correo' => $request['correo'],
                'telefono' => $request['telefono'],
                'sexo' => $request['sexo'],
                'id_parroquia' => $request->get('parroquia')
            ]);
            $id_persona = \App\Models\Persona::select('id')->orderBy('id', 'desc')->first();
        
        } else {
            $id_persona = \App\Models\Persona::select('id')->where('cedula', $request['cedula'])->first();
        }

        $id_usuario = Auth::id();

        $cita_id = Atendidos::create([
                'id_persona' => $id_persona->id,
                'id_user' => $id_usuario,
                'detalles' => $request['detalles'],
                'fecha_atencion' => $request['fecha_cita'],
                'comuna' => $request['nombre_comuna'] ?? null,
                'consejo_comunal' => $request['nombre_consejo'] ?? null,
            ])->id;

        $patria_ids = $request->input('patria');

        if (!empty($patria_ids) && is_array($patria_ids)) {
            foreach ($patria_ids as $patria_id) {
                Asunto::create([
                    'atencion_id' => $cita_id,
                    'patria_id' => $patria_id, 
                ]);
            }
        }
        session()->flash('success_alert', '¡Registro creado exitosamente!');
        return redirect('/lista-personas');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Atendidos::with('personas', 'asuntos.patria', 'usuarios')->find($id);
        $id_parroquia = $cita?->personas?->id_parroquia;

        if($id_parroquia) {
            $proveniencia = Parroquia::with('municipio.estado')->where('id_parroquia', $id_parroquia)->first();
        }
        
        return [$cita, $proveniencia];
    }

    public function getPersonaByCedula($cedula)
    {
        $persona = \App\Models\Persona::where('cedula', $cedula)->first();
        return response()->json($persona);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cita = Atendidos::with('personas', 'asuntos.patria', 'usuarios')->find($id);
        $id_parroquia = $cita?->personas?->id_parroquia;
        $estados = Estado::all();
        $municipios = Municipio::all();
        $parroquias = Parroquia::all();
        $asuntos_patria = Patria::all();

        if($id_parroquia) {
            $proveniencia = Parroquia::with('municipio.estado')->where('id_parroquia', $id_parroquia)->first();
        }
        
        return view('editar', compact(['cita', 'proveniencia', 'estados', 'municipios', 'parroquias', 'asuntos_patria']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cita = Atendidos::find($id);
        $persona = \App\Models\Persona::find($cita->id_persona);
        $id_usuario = Auth::id();
        $asunto = Asunto::where('atencion_id', $id);
        $asunto->delete();
        
        $cita->fill([
            'id_persona' => $cita->id_persona,
            'fecha_atencion' => $request['fecha_atencion'],
            'detalles' => $request['detalles'],
            'id_user' => $id_usuario,
            'comuna' => $request['nombre_comuna'] ?? null,
            'consejo_comunal' => $request['nombre_consejo'] ?? null
        ]);

        $patria_ids = $request->input('patria');       
        if (!empty($patria_ids) && is_array($patria_ids)) {
            foreach ($patria_ids as $patria_id) {
                $asunto->updateOrCreate(
                    ['atencion_id' => $id, 'patria_id' => $patria_id]
                );
            }
        }

        $persona->fill([
            'cedula' => $request['cedula'],
            'nombre' => $request['nombre'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'correo' => $request['correo'],
            'telefono' => $request['telefono'],
            'sexo' => $request['sexo'],
            'id_parroquia' => $request->get('parroquia')
        ]);

        $cita->save();
        $persona->save();
        session()->flash('success_alert', '¡El registro fue actualizado!');
        return redirect("/lista-personas");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Atendidos::destroy($id);
        return redirect("/lista-personas");
    }
}