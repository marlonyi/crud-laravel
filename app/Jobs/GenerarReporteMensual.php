<?php

namespace App\Jobs;

use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerarReporteMensual implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ?int $mes = null,
        public ?int $anio = null
    ) {}

    public function handle(): void
    {
        $mes = $this->mes ?? now()->month;
        $anio = $this->anio ?? now()->year;

        $estadisticas = [
            'total_estudiantes' => Estudiante::count(),
            'total_materias' => Materia::count(),
            'inscripciones_mes' => Inscripcion::whereMonth('fecha_inscripcion', $mes)
                ->whereYear('fecha_inscripcion', $anio)
                ->count(),
            'calificaciones_mes' => Calificacion::whereMonth('fecha', $mes)
                ->whereYear('fecha', $anio)
                ->count(),
            'promedio_general' => round((float) Calificacion::avg('nota'), 2),
            'estudiantes_bajo_rendimiento' => Estudiante::join('inscripcions', 'estudiantes.id', '=', 'inscripcions.estudiante_id')
                ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
                ->groupBy('estudiantes.id')
                ->havingRaw('AVG(calificacions.nota) < 3.0')
                ->count(),
        ];

        Log::info('Reporte mensual generado', $estadisticas);

        // Aquí se podría generar un PDF o enviar por email
    }
}
