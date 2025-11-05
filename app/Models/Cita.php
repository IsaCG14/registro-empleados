<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $table = 'citas';
    protected $fillable = ['id_persona', 'id_user', 'id_patria', 'detalles', 'fecha_cita'];

    public function personas() {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function usuarios() {
        return $this->belongsTo(User::class, 'id_user')->withTrashed();;
    }

    public function patria() {
        return $this->belongsTo(Patria::class ,'id_patria');
    }
}
