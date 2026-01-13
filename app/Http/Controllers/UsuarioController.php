<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("usuario", compact("users"));
    }

    public function changeStatus($id)
    {
        $user = User::withTrashed()->find($id);

        if ($user->deleted_at) {
            $user->restore();
            session()->flash('success_alert', '¡Usuario activado!');
        } 
        return redirect("/usuarios");
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
        //Validar que nombre de usuario no exista
        $user = User::where('user', $request['user'])->withTrashed()->first();
        if ($user) {
            session()->flash('error_alert', '¡El nombre de usuario ya existe!');
            return redirect("/usuarios");
        } else {
            User::create([
                'name' => $request['name'],
                'user' => $request['user'],
                'password' => Hash::make($request['password'])
            ]);
        }
        session()->flash('success_alert', '¡Usuario registrado exitosamente!');
        return redirect("/usuarios");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::find($request->id);

        if (!empty($request['name'])) {
            $user->fill([
                'name' => $request["name"],
                'user' => $request['user'],
                'rol' => !empty($request['rol']) ? 1 : 0,
            ]);
        } else {
            $user->password = Hash::make($request['password']);
        }

        $user->save();
        session()->flash('success_alert', '¡Datos del usuario actualizados!');
        return redirect("/usuarios");
    }

    public function bloq_user($id) {
        $user = User::find($id);
        $user->delete();
        return redirect("/usuarios");
    }

    /**net/be427782-c283-4b38-84a9-0ec492af2bc1
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->find($id);
        $user->forceDelete();
        return redirect("/usuarios");
    }
}
