<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalificacionRequest;
use App\Http\Requests\UpdateCalificacionRequest;
use App\Models\Calificacion;
use App\Models\Inscripcion;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CalificacionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Calificacion::class, 'calificacion');
    }

    public function index(): View
    {
        $calificaciones = Calificacion::with(['inscripcion.estudiante', 'inscripcion.materia'])
            ->latest('fecha')
            ->paginate(15);
        return view('calificaciones.modern', compact('calificaciones'));
    }

    public function create(): View
    {
        $inscripciones = Inscripcion::with(['estudiante', 'materia'])
            ->activas()
            ->orderBy('fecha_inscripcion', 'desc')
            ->get();
        return view('calificaciones.create', compact('inscripciones'));
    }

    public function store(StoreCalificacionRequest $request): RedirectResponse
    {
        Calificacion::create($request->validated());
        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación registrada exitosamente');
    }

    public function show(Calificacion $calificacion): View
    {
        $calificacion->load(['inscripcion.estudiante', 'inscripcion.materia']);
        return view('calificaciones.show', compact('calificacion'));
    }

    public function edit(Calificacion $calificacion): View
    {
        return view('calificaciones.edit', compact('calificacion'));
    }

    public function update(UpdateCalificacionRequest $request, Calificacion $calificacion): RedirectResponse
    {
        $calificacion->update($request->validated());
        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación actualizada exitosamente');
    }

    public function destroy(Calificacion $calificacion): RedirectResponse
    {
        $calificacion->delete();
        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación eliminada exitosamente');
    }
}
