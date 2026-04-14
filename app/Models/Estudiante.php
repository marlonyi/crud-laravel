<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'cedula',
        'fecha_nacimiento',
        'telefono',
        'direccion',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function promedio_general()
    {
        $inscripciones = $this->inscripciones()->with('calificaciones')->get();
        $total_notas = 0;
        $cantidad = 0;
        
        foreach($inscripciones as $inscripcion) {
            $prom = $inscripcion->promedio();
            if($prom) {
                $total_notas += $prom;
                $cantidad++;
            }
        }
        
        return $cantidad > 0 ? $total_notas / $cantidad : 0;
    }
}
