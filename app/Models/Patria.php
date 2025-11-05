<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patria extends Model
{
    use HasFactory;
    protected $table = 'patria';
    protected $fillable = ['opciones'];
    public $timestamps = false;

    public function cita() {
        return $this->hasMany(Cita::class);
    }
}
