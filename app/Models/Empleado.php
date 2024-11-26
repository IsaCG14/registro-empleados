<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Empleado extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "empleados";
    protected $fillable = [
        "cedula",
        "direccion",
        "correo",
        "telefono",
        "cargo",
        "fecha_ingreso",
        "nro_hijos",
        "peso",
        "talla_camisa",
        "talla_pantalon",
        "talla_zapato",
        "patologia",
        "area",
        "tipo",
        "id_persona",
        "id_centro"
    ];

    protected $dates = ['deleted_at'];

    /*protected function fechaIngreso(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y')
        );
    }*/

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function hijo()
    {
        return $this->hasMany(Hijo::class);
    }

    public function centro()
    {
        return $this->hasOne(Centro::class);
    }
}
