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

        $remember = $request->filled('remember');
        $user = User::select('rol')->where("user", $request->user)->first();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session(['usuario' => $request['user']]);
            session(['rol' => $user->rol]);
            session(['id_usuario' => $user->id]);
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