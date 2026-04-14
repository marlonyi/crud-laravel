<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Estudiante;
use App\Models\Materia;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::with(['estudiante', 'materia'])->get();
        return view('inscripciones.index', compact('inscripciones'));
    }

    public function create()
    {
        $estudiantes = Estudiante::all();
        $materias = Materia::all();
        return view('inscripciones.create', compact('estudiantes', 'materias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'materia_id' => 'required|exists:materias,id',
            'fecha_inscripcion' => 'required|date',
            'estado' => 'required|in:activa,completada,cancelada',
        ]);

        $existe = Inscripcion::where('estudiante_id', $validated['estudiante_id'])
                             ->where('materia_id', $validated['materia_id'])
                             ->exists();

        if($existe) {
            return redirect()->back()->withErrors(['error' => 'El estudiante ya está inscrito en esta materia']);
        }

        Inscripcion::create($validated);
        return redirect()->route('inscripciones.index')->with('success', 'Inscripción creada exitosamente');
    }

    public function show(Inscripcion $inscripcion)
    {
        $inscripcion->load(['estudiante', 'materia', 'calificaciones']);
        return view('inscripciones.show', compact('inscripcion'));
    }

    public function edit(Inscripcion $inscripcion)
    {
        $estudiantes = Estudiante::all();
        $materias = Materia::all();
        return view('inscripciones.edit', compact('inscripcion', 'estudiantes', 'materias'));
    }

    public function update(Request $request, Inscripcion $inscripcion)
    {
        $validated = $request->validate([
            'fecha_inscripcion' => 'required|date',
            'estado' => 'required|in:activa,completada,cancelada',
        ]);

        $inscripcion->update($validated);
        return redirect()->route('inscripciones.index')->with('success', 'Inscripción actualizada exitosamente');
    }

    public function destroy(Inscripcion $inscripcion)
    {
        $inscripcion->delete();
        return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada exitosamente');
    }
}
