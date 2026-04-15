<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\UpdateEstudianteRequest;
use App\Models\Estudiante;
use App\Http\Resources\V1\EstudianteResource;
use App\Http\Resources\V1\EstudianteCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EstudianteController extends Controller
{
    public function index(Request $request): EstudianteCollection
    {
        $query = Estudiante::query();

        if ($request->has('buscar')) {
            $query->buscar($request->buscar);
        }

        $estudiantes = $query->latest()->paginate($request->get('per_page', 15));

        return new EstudianteCollection($estudiantes);
    }

    public function store(StoreEstudianteRequest $request): EstudianteResource
    {
        $estudiante = Estudiante::create($request->validated());

        return new EstudianteResource($estudiante);
    }

    public function show(Estudiante $estudiante): EstudianteResource
    {
        $estudiante->load(['inscripciones.materia', 'inscripciones.calificaciones']);

        return new EstudianteResource($estudiante);
    }

    public function update(UpdateEstudianteRequest $request, Estudiante $estudiante): EstudianteResource
    {
        $estudiante->update($request->validated());

        return new EstudianteResource($estudiante);
    }

    public function destroy(Estudiante $estudiante): JsonResponse
    {
        try {
            $estudiante->delete();
            return response()->json(['message' => 'Estudiante eliminado']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se puede eliminar'], 422);
        }
    }
}
