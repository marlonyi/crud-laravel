<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'creditos',
        'descripcion',
        'horas_semana',
        'profesor',
    ];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }
}
