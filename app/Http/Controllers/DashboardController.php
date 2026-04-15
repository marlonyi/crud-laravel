<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index(): View
    {
        $datos = $this->dashboardService->getDatosDashboard();

        return view('dashboard.modern', [
            'totalEstudiantes' => $datos['resumen']['totalEstudiantes'],
            'totalMaterias' => $datos['resumen']['totalMaterias'],
            'totalInscripciones' => $datos['resumen']['totalInscripciones'],
            'totalCalificaciones' => $datos['resumen']['totalCalificaciones'],
            'promedioGeneral' => $datos['promedioGeneral'],
            'calificacionesBajas' => collect($datos['calificacionesBajas']),
            'estudiantesRecientes' => collect($datos['estudiantesRecientes']),
            'materiasPopulares' => collect($datos['materiasPopulares']),
            'inscripcionesRecientes' => collect($datos['inscripcionesRecientes']),
            'estadisticasCalificaciones' => $datos['estadisticasCalificaciones'],
        ]);
    }
}
