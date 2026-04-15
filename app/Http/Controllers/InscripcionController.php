<?php

namespace App\Http\Controllers;

use App\Events\InscripcionCreada;
use App\Http\Requests\StoreInscripcionRequest;
use App\Http\Requests\UpdateInscripcionRequest;
use App\Models\Inscripcion;
use App\Models\Estudiante;
use App\Models\Materia;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InscripcionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Inscripcion::class, 'inscripcion');
    }

    public function index(): View
    {
        $inscripciones = Inscripcion::with(['estudiante', 'materia'])
            ->latest('fecha_inscripcion')
            ->paginate(15);
        return view('inscripciones.modern', compact('inscripciones'));
    }

    public function create(): View
    {
        $estudiantes = Estudiante::orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre')->get();
        return view('inscripciones.create', compact('estudiantes', 'materias'));
    }

    public function store(StoreInscripcionRequest $request): RedirectResponse
    {
        $inscripcion = Inscripcion::create($request->validated());
        
        event(new InscripcionCreada($inscripcion));
        
        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción creada exitosamente');
    }

    public function show(Inscripcion $inscripcion): View
    {
        $inscripcion->load(['estudiante', 'materia', 'calificaciones']);
        return view('inscripciones.show', compact('inscripcion'));
    }

    public function edit(Inscripcion $inscripcion): View
    {
        return view('inscripciones.edit', compact('inscripcion'));
    }

    public function update(UpdateInscripcionRequest $request, Inscripcion $inscripcion): RedirectResponse
    {
        $inscripcion->update($request->validated());
        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción actualizada exitosamente');
    }

    public function destroy(Inscripcion $inscripcion): RedirectResponse
    {
        $inscripcion->delete();
        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción eliminada exitosamente');
    }
}
