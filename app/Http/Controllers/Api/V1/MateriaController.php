<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMateriaRequest;
use App\Http\Requests\UpdateMateriaRequest;
use App\Models\Materia;
use App\Http\Resources\V1\MateriaResource;
use App\Http\Resources\V1\MateriaCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MateriaController extends Controller
{
    public function index(Request $request): MateriaCollection
    {
        $query = Materia::query();

        if ($request->has('buscar')) {
            $query->buscar($request->buscar);
        }

        if ($request->has('profesor')) {
            $query->porProfesor($request->profesor);
        }

        $materias = $query->withCount('inscripciones')->latest()->paginate($request->get('per_page', 15));

        return new MateriaCollection($materias);
    }

    public function store(StoreMateriaRequest $request): MateriaResource
    {
        $materia = Materia::create($request->validated());
        return new MateriaResource($materia);
    }

    public function show(Materia $materia): MateriaResource
    {
        $materia->load(['inscripciones.estudiante', 'inscripciones.calificaciones']);
        return new MateriaResource($materia);
    }

    public function update(UpdateMateriaRequest $request, Materia $materia): MateriaResource
    {
        $materia->update($request->validated());
        return new MateriaResource($materia);
    }

    public function destroy(Materia $materia): JsonResponse
    {
        try {
            $materia->delete();
            return response()->json(['message' => 'Materia eliminada']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se puede eliminar'], 422);
        }
    }
}
