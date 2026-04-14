<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all();
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:materias,codigo',
            'creditos' => 'required|integer|min:1|max:10',
            'descripcion' => 'nullable|string',
            'horas_semana' => 'nullable|integer|min:1',
            'profesor' => 'nullable|string|max:255',
        ]);

        Materia::create($validated);
        return redirect()->route('materias.index')->with('success', 'Materia creada exitosamente');
    }

    public function show(Materia $materia)
    {
        $materia->load('inscripciones.estudiante');
        return view('materias.show', compact('materia'));
    }

    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:materias,codigo,' . $materia->id,
            'creditos' => 'required|integer|min:1|max:10',
            'descripcion' => 'nullable|string',
            'horas_semana' => 'nullable|integer|min:1',
            'profesor' => 'nullable|string|max:255',
        ]);

        $materia->update($validated);
        return redirect()->route('materias.index')->with('success', 'Materia actualizada exitosamente');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();
        return redirect()->route('materias.index')->with('success', 'Materia eliminada exitosamente');
    }
}
