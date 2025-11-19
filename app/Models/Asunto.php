<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asunto extends Model
{
    use HasFactory;
    protected $table = 'asunto';
    protected $fillable = ['cita_id', 'patria_id'];

    public function patria() {
        return $this->belongsTo(Patria::class ,'patria_id');
    }

    public function cita() {
        return $this->belongsTo(Cita::class, 'cita_id');
    }
}
