<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Empleado extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->get();
        return view("index", compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = \App\Models\Area::all();
        return view("form", compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Guardar informacion personal
        \App\Models\Persona::create([
            'nombre' => $request['nombre'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'sexo' => $request['sexo'],
            'estudiante' => $request->input('estudiante', 0) //0 si no esta marcado
        ]);
        //Obtener id con el que se registro
        $id_persona = \App\Models\Persona::select('id')->latest()->first();
        $nro_hijos = ($request['nro_hijos'] == null) ? 0 : $request['nro_hijos'];

        //Guardar informacion de empleados
        \App\Models\Empleado::create([
            'cedula' => $request['cedula'],
            'direccion' => $request['direccion'],
            'correo' => $request['correo'],
            'telefono' => $request['telefono'],
            'cargo' => $request['cargo'],
            'fecha_ingreso' => $request['fecha_ingreso'],
            'nro_hijos' => $nro_hijos,
            'peso' => $request['peso'],
            'talla_camisa' => $request['talla_camisa'],
            'talla_pantalon' => $request['talla_pantalon'],
            'talla_zapato' => $request['talla_zapato'],
            'patologia' => $request['patologia'],
            'centro_electoral' => $request['centro_electoral'],
            'area' => $request['area'],
            'tipo' => $request['tipo'],
            'id_persona' => $id_persona->id
        ]);

        //Obtener id con el que se registro
        $id_empleado = \App\Models\Empleado::select('id')->latest()->first();

        //guardar informacion de carnet de empleado
        if ($request['codigo'] != null) {
            \App\Models\Carnet::create([
                'codigo' => $request['codigo'],
                'serial' => $request['serial'],
                'id_empleado' => $id_empleado->id
            ]);
        }

        //Si tiene hijos
        if ($nro_hijos != 0) {
            //Guardar informacion de hijo
            $hijos = array_map(
                null,
                $request->input('nombres'),
                $request->input('fechas_nac'),
                $request->input('sexos'),
                $request->input('estudiante', 0)
            );

            foreach ($hijos as $hijo) {
                list($nombre, $fecha_nacimiento, $sexo, $estudiante) = $hijo;
                \App\Models\Persona::create([
                    'nombre' => $nombre,
                    'sexo' => $sexo,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'estudiante' => $estudiante
                ]);

                $id_hijo = \App\Models\Persona::select('id')->latest()->first();
                \App\Models\Hijo::create([
                    'id_persona' => $id_hijo->id,
                    'id_empleado' => $id_empleado->id
                ]);
            }
        }

        return view('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleado = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'personas.*')->where('empleados.id', $id)->first();
        return response()->json($empleado);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $carnet = \App\Models\Carnet::all()->where('id_empleado', $id)->first();
        $empleado = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->where('empleados.id', $id)->first();
        $areas = \App\Models\Area::all();
        $hijos = \App\Models\Hijo::join('personas', 'hijos.id_persona', "=", 'personas.id')->select('personas.*', 'hijos.*')->where("hijos.id_empleado", $id)->get();
        return view('editar', ['empleado' => $empleado, 'areas' => $areas, 'carnet' => $carnet, 'hijos' => $hijos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_empleado)
    {
        $id = $request['id_persona'];
        $persona = \App\Models\Persona::find($id);
        $persona->nombre = $request['nombre'];
        $persona->fecha_nacimiento = $request['fecha_nacimiento'];
        $persona->sexo = $request['sexo'];
        $persona->estudiante = $request['estudiante'];
        $persona->save();

        $nro_hijos = ($request['nro_hijos'] == null) ? 0 : $request['nro_hijos'];

        //Guardar informacion de empleados
        $empleado = \App\Models\Empleado::find($id_empleado);
        $empleado->cedula = $request['cedula'];
        $empleado->direccion = $request['direccion'];
        $empleado->correo = $request['correo'];
        $empleado->telefono = $request['telefono'];
        $empleado->cargo = $request['cargo'];
        $empleado->fecha_ingreso = $request['fecha_ingreso'];
        $empleado->nro_hijos = $nro_hijos;
        $empleado->peso = $request['peso'];
        $empleado->talla_camisa = $request['talla_camisa'];
        $empleado->talla_pantalon = $request['talla_pantalon'];
        $empleado->talla_zapato = $request['talla_zapato'];
        $empleado->patologia = $request['patologia'];
        $empleado->centro_electoral = $request['centro_electoral'];
        $empleado->area = $request['area'];
        $empleado->tipo = $request['tipo'];
        $empleado->save();

        //guardar informacion de carnet de empleado
        if ($request['codigo'] != null) {
            $carnet = \App\Models\Carnet::where('id_empleado', $id_empleado)->first();
            if ($carnet != null) {
                //Si ya esta registrado
                $carnet->codigo = $request['codigo'];
                $carnet->serial = $request['serial'];
                $carnet->save();
            } else {
                \App\Models\Carnet::create([
                    'codigo' => $request['codigo'],
                    'serial' => $request['serial'],
                    'id_empleado' => $id_empleado
                ]);
            }
        }

        return redirect("/lista-empleados?editado=1");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = \App\Models\Empleado::find($id);
        $empleado->delete();

        return redirect("/lista-empleados");
    }
}
