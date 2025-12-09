<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendidos extends Model
{
    use HasFactory;
    protected $table = 'atendidos';
    protected $fillable = ['id_persona', 'id_user', 'detalles', 'fecha_atencion', 'comuna', 'consejo_comunal'];

    public function personas() {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function usuarios() {
        return $this->belongsTo(User::class, 'id_user')->withTrashed();;
    }

    public function asuntos() {
        return $this->hasMany(Asunto::class, 'atencion_id');
    }

    public function citas() {
        return $this->hasMany(Asunto::class, 'id_atencion');
    }
}
