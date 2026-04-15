<?php

namespace App\Services;

use App\Models\Estudiante;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\DB;

class GradeCalculationService
{
    /**
     * Calcula el promedio de notas de una inscripción usando query SQL optimizada
     */
    public function calcularPromedioInscripcion(Inscripcion $inscripcion): ?float
    {
        $promedio = $inscripcion->calificaciones()->avg('nota');
        return $promedio ? round((float) $promedio, 2) : null;
    }

    /**
     * Calcula el promedio general de un estudiante usando query SQL optimizada
     */
    public function calcularPromedioGeneral(Estudiante $estudiante): float
    {
        $promedio = $estudiante->inscripciones()
            ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
            ->avg('calificacions.nota');

        return $promedio ? round((float) $promedio, 2) : 0;
    }

    /**
     * Calcula el promedio por materia para todos los estudiantes
     */
    public function calcularPromedioPorMateria(int $materiaId): array
    {
        return Inscripcion::where('materia_id', $materiaId)
            ->with(['estudiante', 'materia'])
            ->get()
            ->map(function ($inscripcion) {
                return [
                    'estudiante' => $inscripcion->estudiante->nombre_completo,
                    'promedio' => $this->calcularPromedioInscripcion($inscripcion),
                ];
            })
            ->toArray();
    }

    /**
     * Obtiene estudiantes con bajo rendimiento (promedio < threshold)
     */
    public function getEstudiantesBajoRendimiento(float $threshold = 3.0): array
    {
        return Estudiante::select([
                'estudiantes.id',
                'estudiantes.nombre',
                'estudiantes.apellido',
                DB::raw('ROUND(AVG(calificacions.nota), 2) as promedio')
            ])
            ->join('inscripcions', 'estudiantes.id', '=', 'inscripcions.estudiante_id')
            ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
            ->groupBy('estudiantes.id', 'estudiantes.nombre', 'estudiantes.apellido')
            ->havingRaw('AVG(calificacions.nota) < ?', [$threshold])
            ->orderBy('promedio', 'asc')
            ->get()
            ->toArray();
    }

    /**
     * Verifica si una calificación está aprobada (>= 3.0)
     */
    public function estaAprobada(float $nota): bool
    {
        return $nota >= 3.0;
    }

    /**
     * Obtiene el color según la nota para visualización
     */
    public function getColorPorNota(float $nota): string
    {
        if ($nota >= 4.0) {
            return 'success'; // verde
        } elseif ($nota >= 3.0) {
            return 'warning'; // naranja
        } else {
            return 'danger'; // rojo
        }
    }

    /**
     * Calcula estadísticas de calificaciones para un estudiante en una materia
     */
    public function getEstadisticasEstudianteMateria(int $estudianteId, int $materiaId): ?array
    {
        $stats = Inscripcion::where('estudiante_id', $estudianteId)
            ->where('materia_id', $materiaId)
            ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
            ->selectRaw('
                COUNT(calificacions.id) as total_notas,
                ROUND(AVG(calificacions.nota), 2) as promedio,
                ROUND(MIN(calificacions.nota), 2) as minima,
                ROUND(MAX(calificacions.nota), 2) as maxima
            ')
            ->first();

        return $stats ? $stats->toArray() : null;
    }
}
