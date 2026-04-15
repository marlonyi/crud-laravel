<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\InscripcionEstado;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInscripcionRequest;
use App\Http\Requests\UpdateInscripcionRequest;
use App\Models\Inscripcion;
use App\Http\Resources\V1\InscripcionResource;
use App\Http\Resources\V1\InscripcionCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InscripcionController extends Controller
{
    public function index(Request $request): InscripcionCollection
    {
        $query = Inscripcion::with(['estudiante', 'materia']);

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('estudiante_id')) {
            $query->porEstudiante($request->estudiante_id);
        }

        if ($request->has('materia_id')) {
            $query->porMateria($request->materia_id);
        }

        $inscripciones = $query->latest('fecha_inscripcion')->paginate($request->get('per_page', 15));

        return new InscripcionCollection($inscripciones);
    }

    public function store(StoreInscripcionRequest $request): InscripcionResource
    {
        $inscripcion = Inscripcion::create($request->validated());
        $inscripcion->load(['estudiante', 'materia']);

        return new InscripcionResource($inscripcion);
    }

    public function show(Inscripcion $inscripcion): InscripcionResource
    {
        $inscripcion->load(['estudiante', 'materia', 'calificaciones']);
        return new InscripcionResource($inscripcion);
    }

    public function update(UpdateInscripcionRequest $request, Inscripcion $inscripcion): InscripcionResource
    {
        $inscripcion->update($request->validated());
        return new InscripcionResource($inscripcion);
    }

    public function destroy(Inscripcion $inscripcion): JsonResponse
    {
        $inscripcion->delete();
        return response()->json(['message' => 'Inscripción eliminada']);
    }
}
