<?php

namespace App\Services;

use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getResumen(): array
    {
        return [
            'totalEstudiantes' => Estudiante::count(),
            'totalMaterias' => Materia::count(),
            'totalInscripciones' => Inscripcion::count(),
            'totalCalificaciones' => Calificacion::count(),
        ];
    }

    public function getPromedioGeneral(): float
    {
        return (float) Calificacion::avg('nota') ?? 0;
    }

    public function getCalificacionesBajas(): array
    {
        return Calificacion::where('nota', '<', 3.0)
            ->with(['inscripcion.estudiante', 'inscripcion.materia'])
            ->latest()
            ->take(5)
            ->get()
            ->toArray();
    }

    public function getEstudiantesRecientes(int $limit = 5): array
    {
        return Estudiante::latest('created_at')
            ->take($limit)
            ->get()
            ->map(function ($estudiante) {
                return array_merge($estudiante->toArray(), [
                    'created_at' => [
                        'date' => $estudiante->created_at->toDateString(),
                        'diff_for_humans' => $estudiante->created_at->diffForHumans(),
                    ],
                ]);
            })
            ->toArray();
    }

    public function getMateriasPopulares(int $limit = 5): array
    {
        return Materia::withCount('inscripciones')
            ->orderByDesc('inscripciones_count')
            ->take($limit)
            ->get()
            ->toArray();
    }

    public function getInscripcionesRecientes(int $limit = 5): array
    {
        return Inscripcion::with(['estudiante', 'materia'])
            ->latest('fecha_inscripcion')
            ->take($limit)
            ->get()
            ->map(function ($inscripcion) {
                return array_merge($inscripcion->toArray(), [
                    'fecha_inscripcion' => [
                        'date' => $inscripcion->fecha_inscripcion->toDateString(),
                    ],
                    'estudiante' => $inscripcion->estudiante->only(['id', 'nombre', 'apellido']),
                    'materia' => $inscripcion->materia->only(['id', 'nombre', 'codigo']),
                ]);
            })
            ->toArray();
    }

    public function getEstadisticasCalificaciones(): array
    {
        $stats = Calificacion::selectRaw('
            COUNT(*) as total,
            ROUND(AVG(nota), 2) as promedio,
            ROUND(MIN(nota), 2) as minima,
            ROUND(MAX(nota), 2) as maxima
        ')->first();

        // SQLite no soporta STDDEV directamente, calculamos manualmente si hay datos
        $desviacion = null;
        if ($stats && $stats->total > 1) {
            $notas = Calificacion::pluck('nota')->toArray();
            $media = (float) $stats->promedio;
            $varianza = array_sum(array_map(function ($n) use ($media) {
                return pow((float) $n - $media, 2);
            }, $notas)) / $stats->total;
            $desviacion = round(sqrt($varianza), 2);
        }

        return array_merge($stats->toArray(), ['desviacion' => $desviacion]);
    }

    public function getDatosDashboard(): array
    {
        return [
            'resumen' => $this->getResumen(),
            'promedioGeneral' => $this->getPromedioGeneral(),
            'calificacionesBajas' => $this->getCalificacionesBajas(),
            'estudiantesRecientes' => $this->getEstudiantesRecientes(),
            'materiasPopulares' => $this->getMateriasPopulares(),
            'inscripcionesRecientes' => $this->getInscripcionesRecientes(),
            'estadisticasCalificaciones' => $this->getEstadisticasCalificaciones(),
        ];
    }
}
