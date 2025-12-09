<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $table = 'citas';
    protected $fillable = ['fecha_cita', 'hora_cita', 'id_atencion', 'status'];
    
    public function atendidos() {
        return $this->belongsTo(Atendidos::class, 'id_atencion');
    }
}
