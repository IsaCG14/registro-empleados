<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "personas";
    protected $fillable = ["nombre", "sexo", "fecha_nacimiento", "estudiante"];
    protected $dates = ['deleted_at'];

    public function empleado()
    {
        return $this->hasOne(Empleado::class);
    }

    public function hijo()
    {
        return $this->hasOne(Hijo::class);
    }
}
