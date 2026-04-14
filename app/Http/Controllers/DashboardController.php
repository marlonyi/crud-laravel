<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Inscripcion;
use App\Models\Calificacion;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEstudiantes = Estudiante::count();
        $totalMaterias = Materia::count();
        $totalInscripciones = Inscripcion::count();
        $totalCalificaciones = Calificacion::count();

        // Últimos estudiantes registrados
        $estudiantesRecientes = Estudiante::latest()->take(5)->get();

        // Últimas inscripciones
        $inscripcionesRecientes = Inscripcion::with(['estudiante', 'materia'])
            ->latest()
            ->take(5)
            ->get();

        // Materias más inscritas
        $materiasPopulares = Materia::withCount('inscripciones')
            ->orderByDesc('inscripciones_count')
            ->take(5)
            ->get();

        // Promedio general de calificaciones
        $promedioGeneral = Calificacion::avg('nota');

        // Calificaciones bajas (menores a 3.0)
        $calificacionesBajas = Calificacion::with(['inscripcion.estudiante', 'inscripcion.materia'])
            ->where('nota', '<', 3.0)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalEstudiantes',
            'totalMaterias',
            'totalInscripciones',
            'totalCalificaciones',
            'estudiantesRecientes',
            'inscripcionesRecientes',
            'materiasPopulares',
            'promedioGeneral',
            'calificacionesBajas'
        ));
    }
}
