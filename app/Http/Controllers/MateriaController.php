<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMateriaRequest;
use App\Http\Requests\UpdateMateriaRequest;
use App\Models\Materia;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MateriaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Materia::class, 'materia');
    }

    public function index(): View
    {
        $materias = Materia::withCount('inscripciones')
            ->latest()
            ->paginate(15);
        return view('materias.modern', compact('materias'));
    }

    public function create(): View
    {
        return view('materias.create');
    }

    public function store(StoreMateriaRequest $request): RedirectResponse
    {
        Materia::create($request->validated());
        return redirect()->route('materias.index')
            ->with('success', 'Materia creada exitosamente');
    }

    public function show(Materia $materia): View
    {
        $materia->load(['inscripciones.estudiante', 'inscripciones.calificaciones']);
        return view('materias.show', compact('materia'));
    }

    public function edit(Materia $materia): View
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(UpdateMateriaRequest $request, Materia $materia): RedirectResponse
    {
        $materia->update($request->validated());
        return redirect()->route('materias.index')
            ->with('success', 'Materia actualizada exitosamente');
    }

    public function destroy(Materia $materia): RedirectResponse
    {
        try {
            $materia->delete();
            return redirect()->route('materias.index')
                ->with('success', 'Materia eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la materia porque tiene registros relacionados');
        }
    }
}
