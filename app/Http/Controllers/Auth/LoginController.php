<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('user', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();
            session(['usuario' => $request['user']]);
            session(['rol' => $user->rol]);
            session(['id_usuario' => $user->id]);

            //Obtener citas del dia y guardarlas en sesion
            $hoy = date('Y-m-d');
            //$hoy = date('2025-12-19'); //Fecha fija para pruebas
            $citas_hoy = \App\Models\Cita::where('fecha_cita', $hoy)->get();

            if ($citas_hoy->count() > 0) {
                session()->flash('citas_alert', 'Hay '.$citas_hoy->count() . ' cita(s) para hoy');
            } else {
                session()->forget('citas_alert');
            }

            return redirect()->intended('lista-personas');
        } else {
            throw ValidationValidationException::withMessages(['user' => 'Usuario o contraseña inválidos']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}