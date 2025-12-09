<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asunto extends Model
{
    use HasFactory;
    protected $table = 'asunto';
    protected $fillable = ['atencion_id', 'patria_id'];

    public function patria() {
        return $this->belongsTo(Patria::class ,'patria_id');
    }

    public function atendidos() {
        return $this->belongsTo(Atendidos::class, 'atencion_id');
    }
}
