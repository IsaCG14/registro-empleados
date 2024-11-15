<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Centro extends Model
{
    use HasFactory;
    protected $table = "centros";
    protected $fillable = ["nombre_centro"];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
