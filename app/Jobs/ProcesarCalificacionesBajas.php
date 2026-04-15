<?php

namespace App\Jobs;

use App\Models\Calificacion;
use App\Models\Estudiante;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcesarCalificacionesBajas implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public float $umbral = 3.0
    ) {}

    public function handle(): void
    {
        $calificacionesBajas = Calificacion::where('nota', '<', $this->umbral)
            ->with(['inscripcion.estudiante', 'inscripcion.materia'])
            ->get();

        Log::warning("Se encontraron {$calificacionesBajas->count()} calificaciones bajas (nota < {$this->umbral})");

        foreach ($calificacionesBajas as $calificacion) {
            Log::warning(sprintf(
                'Estudiante: %s, Materia: %s, Nota: %.2f',
                $calificacion->inscripcion->estudiante->nombre_completo,
                $calificacion->inscripcion->materia->nombre,
                $calificacion->nota
            ));
        }

        // Aquí se podría enviar un reporte por email o generar alertas
    }
}
