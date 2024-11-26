<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "personas";
    protected $fillable = ["nombre", "sexo", "fecha_nacimiento", "estudiante"];
    protected $dates = ['deleted_at'];

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value)
        );
    }

    protected function fechaNacimiento(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y')
        );
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class);
    }

    public function hijo()
    {
        return $this->hasOne(Hijo::class);
    }
}