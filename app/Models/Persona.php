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
    protected $fillable = ["cedula", "nombre", "sexo", "fecha_nacimiento",
        "correo",
        "telefono", "id_parroquia"];
    protected $dates = ['deleted_at'];

    // Cita.php

    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class, 'id_parroquia');
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value)
        );
    }

    public function cita() {
        return $this->hasMany(Cita::class);
    }
}