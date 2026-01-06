<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\ParroquiaController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AtendidosController;
use App\Http\Controllers\Persona;
use App\Models\Usuario;
use App\Models\User;
use App\Models\Cita;
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

Route::get('/formulario', [Persona::class, "create"])->name("form")->middleware('auth');
Route::get("/lista-personas", [Persona::class, "index"])->name("index")->middleware('auth');
Route::post('/guardar-persona', [Persona::class, "store"])->name("store");
Route::get("/obtener-informacion/{id}", [Persona::class, "show"]);
Route::get("/eliminar-persona/{id}", [Persona::class, "destroy"]);
Route::get("/editar-persona/{id}", [Persona::class, "edit"])->middleware('auth');
Route::put("/actualizar-persona/{id}", [Persona::class, "update"])->name("update");

Route::get('/obtener-municipios/{id}', [MunicipioController::class, 'show']);
Route::get('/obtener-parroquias/{id}', [ParroquiaController::class, 'show']);

Route::get("/success", function () {
    return view("success");
})->name("success");

Route::get("/error", function () {
    return view("error");
})->name("error");

Route::get("/grafica", [AtendidosController::class, "obtener_graficas"])->name("grafica")->middleware('auth');

Route::get("/reportes", function () {
    return view("reportes");
})->name("reportes")->middleware('auth');

Route::get("/calendario", function () {
    return view("calendario");
})->name("calendario")->middleware('auth');

//Route::get("usuarios", [UsuarioController::class, 'index'])->middleware('check.user.access');
Route::post("registrar-usuario", [UsuarioController::class, "store"]);
Route::post("editar-usuario", [UsuarioController::class, "update"]);
Route::get("destroy/{id}", [UsuarioController::class, "destroy"]);
Route::get("usuarios/{state?}", function($state = 0){

    $state = request()->get('state');
    if($state == 1 || $state === null){
        $users = User::all();
    } else {
        $users = User::onlyTrashed()->get();
    }
        
    return view('usuario', compact('users'));

})->middleware('check.user.access');
Route::get("cambiar-estado/{id}", [UsuarioController::class, "changeStatus"]);

Route::get('/pdf', [PDFController::class, "getPDF"]);

Route::get("/offline", function () {
    return view("vendor.silviolleite.resources.offline");
});
//Apis
Route::get("/api/parroquia/{id}", [ParroquiaController::class, "obtener_ubicacion_completa"]);
Route::get("/api/persona/{cedula}", [Persona::class, "getPersonaByCedula"]);

Route::get("/terminar-cita/{id}", [CitaController::class, "update"])->name("terminar-cita")->middleware('auth');
Route::get("/cancelar-cita/{id}", [CitaController::class, "destroy"])->name("cancelar-cita")->middleware('auth');
Route::get("/agendar-cita/{id}", [CitaController::class, "create"])->name("agendar-cita")->middleware('auth');
Route::post("/guardar-cita", [CitaController::class, "store"])->name("guardar-cita");
Route::get("/api/citas/{fecha}", [CitaController::class, "show"]);
Route::get("/citas", [CitaController::class, "index"])->name("citas")->middleware('auth');
Route::get("/api/citas-mes/{mes}", [CitaController::class, "citasMes"]);