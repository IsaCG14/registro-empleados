<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Carnet;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\Empleado;
use App\Http\Controllers\Hijo;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Persona;
use App\Models\Usuario;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException as ValidationValidationException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function () {
    return redirect("/formulario");
});
Route::get("/login", [User::class, function () {
    return view('login');
}])->name('login')->middleware('guest');

Route::post('login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/formulario', [Empleado::class, "create"])->name("form");
Route::get("/lista-empleados", [Empleado::class, "index"])->name("index")->middleware('auth');
Route::post('/guardar-empleado', [Empleado::class, "store"])->name("store");
Route::get("/obtener-informacion/{id}", [Empleado::class, "show"]);
Route::get("/eliminar-empleado/{id}", [Empleado::class, "destroy"]);
Route::get("/editar-empleado/{id}", [Empleado::class, "edit"])->middleware('auth');
Route::put("/actualizar-empleado/{id_empleado}", [Empleado::class, "update"])->name("update");

Route::get("/obtener-hijos/{id}", [Hijo::class, "show"]);
Route::post("/registrar-hijo", [Hijo::class, "store"]);
Route::get("/eliminar-hijo/{id}", [Hijo::class, "destroy"]);

Route::get("/obtener-area/{id}", [AreaController::class, "show"]);

Route::get("/obtener-carnet/{id}", [Carnet::class, "show"]);

Route::get("/success", function () {
    return view("success");
})->name("success");

Route::get("/error", function () {
    return view("error");
})->name("error");

Route::get("/grafica", function () {
    $empleados = \App\Models\Empleado::join('personas', 'empleados.id_persona', '=', 'personas.id')->select('empleados.*', 'empleados.id AS id_empleado', 'personas.*')->get();
    $centros = \App\Models\Centro::select('nombre_centro', \App\Models\Centro::raw('COUNT(empleados.id) as total'))
        ->join('empleados', 'centros.id', '=', 'empleados.id_centro')
        ->whereNull('empleados.deleted_at')
        ->groupBy('nombre_centro')
        ->get();
    return view('grafica', ['empleados' => $empleados, 'centros' => $centros]);
})->name("grafica")->middleware('auth');

Route::get("/reportes", function () {
    $centros = \App\Models\Centro::all();
    $areas = \App\Models\Area::all();
    return view("reportes", ['centros' => $centros, 'areas' => $areas]);
})->name("reportes")->middleware('auth');

Route::resource("usuarios", UsuarioController::class)->middleware('check.user.access');
Route::post("registrar-usuario", [UsuarioController::class, "store"]);
Route::post("editar-usuario", [UsuarioController::class, "update"]);
Route::get("destroy/{id}", [UsuarioController::class, "destroy"]);

Route::resource("centros", CentroController::class);

/*
1: por area
2: por sexo
3: por tipo de empleado
4: a partir de fecha de ingreso
*/
Route::get('/pdf', [PDFController::class, "getPDF"]);