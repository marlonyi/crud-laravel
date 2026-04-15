<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\UpdateEstudianteRequest;
use App\Models\Estudiante;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EstudianteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Estudiante::class, 'estudiante');
    }

    public function index(): View
    {
        $estudiantes = Estudiante::latest()->paginate(15);
        return view('estudiantes.modern', compact('estudiantes'));
    }

    public function create(): View
    {
        return view('estudiantes.create');
    }

    public function store(StoreEstudianteRequest $request): RedirectResponse
    {
        Estudiante::create($request->validated());
        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante creado exitosamente');
    }

    public function show(Estudiante $estudiante): View
    {
        $estudiante->load(['inscripciones.materia', 'inscripciones.calificaciones']);
        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante): View
    {
        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(UpdateEstudianteRequest $request, Estudiante $estudiante): RedirectResponse
    {
        $estudiante->update($request->validated());
        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante actualizado exitosamente');
    }

    public function destroy(Estudiante $estudiante): RedirectResponse
    {
        try {
            $estudiante->delete();
            return redirect()->route('estudiantes.index')
                ->with('success', 'Estudiante eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el estudiante porque tiene registros relacionados');
        }
    }
}
