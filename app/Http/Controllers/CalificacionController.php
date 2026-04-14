<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function index()
    {
        $calificaciones = Calificacion::with(['inscripcion.estudiante', 'inscripcion.materia'])->get();
        return view('calificaciones.index', compact('calificaciones'));
    }

    public function create()
    {
        $inscripciones = Inscripcion::with(['estudiante', 'materia'])->get();
        return view('calificaciones.create', compact('inscripciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscripcion_id' => 'required|exists:inscripcions,id',
            'nota' => 'required|numeric|min:0|max:5',
            'tipo' => 'required|string',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        Calificacion::create($validated);
        return redirect()->route('calificaciones.index')->with('success', 'Calificación registrada exitosamente');
    }

    public function show(Calificacion $calificacion)
    {
        $calificacion->load(['inscripcion.estudiante', 'inscripcion.materia']);
        return view('calificaciones.show', compact('calificacion'));
    }

    public function edit(Calificacion $calificacion)
    {
        $inscripciones = Inscripcion::with(['estudiante', 'materia'])->get();
        return view('calificaciones.edit', compact('calificacion', 'inscripciones'));
    }

    public function update(Request $request, Calificacion $calificacion)
    {
        $validated = $request->validate([
            'nota' => 'required|numeric|min:0|max:5',
            'tipo' => 'required|string',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        $calificacion->update($validated);
        return redirect()->route('calificaciones.index')->with('success', 'Calificación actualizada exitosamente');
    }

    public function destroy(Calificacion $calificacion)
    {
        $calificacion->delete();
        return redirect()->route('calificaciones.index')->with('success', 'Calificación eliminada exitosamente');
    }
}
