<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalificacionRequest;
use App\Http\Requests\UpdateCalificacionRequest;
use App\Models\Calificacion;
use App\Http\Resources\V1\CalificacionResource;
use App\Http\Resources\V1\CalificacionCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CalificacionController extends Controller
{
    public function index(Request $request): CalificacionCollection
    {
        $query = Calificacion::with(['inscripcion.estudiante', 'inscripcion.materia']);

        if ($request->has('inscripcion_id')) {
            $query->where('inscripcion_id', $request->inscripcion_id);
        }

        if ($request->has('aprobadas')) {
            $query->aprobadas();
        }

        if ($request->has('reprobadas')) {
            $query->reprobadas();
        }

        $calificaciones = $query->latest('fecha')->paginate($request->get('per_page', 15));

        return new CalificacionCollection($calificaciones);
    }

    public function store(StoreCalificacionRequest $request): CalificacionResource
    {
        $calificacion = Calificacion::create($request->validated());
        $calificacion->load(['inscripcion.estudiante', 'inscripcion.materia']);

        return new CalificacionResource($calificacion);
    }

    public function show(Calificacion $calificacion): CalificacionResource
    {
        $calificacion->load(['inscripcion.estudiante', 'inscripcion.materia']);
        return new CalificacionResource($calificacion);
    }

    public function update(UpdateCalificacionRequest $request, Calificacion $calificacion): CalificacionResource
    {
        $calificacion->update($request->validated());
        return new CalificacionResource($calificacion);
    }

    public function destroy(Calificacion $calificacion): JsonResponse
    {
        $calificacion->delete();
        return response()->json(['message' => 'Calificación eliminada']);
    }
}
