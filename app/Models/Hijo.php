<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hijo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "hijos";
    protected $fillable = ["id_persona", "id_empleado"];
    protected $dates = ['deleted_at'];

    public function empleado(){
        return $this->belongsTo(Empleado::class);
    }

    public function persona(){
        return $this->belongsTo(Persona::class);
    }
}
