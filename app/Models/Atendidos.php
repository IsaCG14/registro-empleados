<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendidos extends Model
{
    use HasFactory;
    protected $table = 'atendidos';
    protected $fillable = ['id_persona', 'id_user', 'detalles', 'fecha_atencion'];

    public function personas()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function usuarios()
    {
        return $this->belongsTo(User::class, 'id_user')->withTrashed();
        ;
    }

    public function asuntos()
    {
        return $this->hasMany(Asunto::class, 'atencion_id');
    }

    public function citas()
    {
        return $this->hasMany(Asunto::class, 'id_atencion');
    }

    public function scopeFiltros($query, $request)
    {
        $sexo = $request->input('sexo');
        $estado = $request->input('estado');
        $municipio = $request->input('municipio');
        $parroquia = $request->input('parroquia');
        $asunto = $request->input('asunto');
        $comunidad = $request->input('comunidad');

        if ($sexo !== null && $sexo !== '') {
            $query->whereHas('personas', function ($q) use ($sexo) {
                $q->where('sexo', $sexo);
            });
        }

        if ($parroquia) {
            $parroquias = Parroquia::where('id_parroquia', $parroquia)->pluck('id_parroquia');
            $query->whereHas('personas', function ($q) use ($parroquias) {
                $q->whereIn('id_parroquia', $parroquias);
            });
        } elseif ($municipio) {
            $parroquias = Parroquia::where('id_municipio', $municipio)->pluck('id_parroquia');
            $query->whereHas('personas', function ($q) use ($parroquias) {
                $q->whereIn('id_parroquia', $parroquias);
            });
        } elseif ($estado) {
            $municipios = Municipio::where('id_estado', $estado)->pluck('id_municipio');
            $parroquias = Parroquia::whereIn('id_municipio', $municipios)->pluck('id_parroquia');
            $query->whereHas('personas', function ($q) use ($parroquias) {
                $q->whereIn('id_parroquia', $parroquias);
            });
        }

        if ($asunto) {
            $query->whereHas('asuntos', function ($q) use ($asunto) {
                $q->where('patria_id', $asunto);
            });
        }

        if ($comunidad) {
            $query->whereHas('personas', function ($q) use ($comunidad) {
                if ($comunidad === 'comuna') {
                    $q->whereNotNull('comuna')->where('comuna', '!=', '');
                } elseif ($comunidad === 'circuito') {
                    $q->whereNotNull('consejo_comunal')->where('consejo_comunal', '!=', '');
                } elseif ($comunidad === 'sin_especificar') {
                    $q->where(function ($a) {
                        $a->whereNull('comuna')->orWhere('comuna', '');
                    })->where(function ($b) {
                        $b->whereNull('consejo_comunal')->orWhere('consejo_comunal', '');
                    });
                }
            });
        }

        return $query;
    }
}
