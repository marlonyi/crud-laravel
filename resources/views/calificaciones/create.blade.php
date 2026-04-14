@extends('layout')

@section('title', 'Registrar Calificación')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Registrar Nueva Calificación</h1>

        <form method="POST" action="{{ route('calificaciones.store') }}" class="mt-4">
            @csrf

            <div class="mb-3">
                <label for="inscripcion_id" class="form-label">Inscripción (Estudiante - Materia) *</label>
                <select class="form-control @error('inscripcion_id') is-invalid @enderror" id="inscripcion_id" name="inscripcion_id" required>
                    <option value="">-- Selecciona una inscripción --</option>
                    @foreach($inscripciones as $inscripcion)
                        <option value="{{ $inscripcion->id }}" {{ old('inscripcion_id') == $inscripcion->id ? 'selected' : '' }}>
                            {{ $inscripcion->estudiante->nombre }} - {{ $inscripcion->materia->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('inscripcion_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nota" class="form-label">Nota (0.00 - 5.00) *</label>
                <input type="number" step="0.01" class="form-control @error('nota') is-invalid @enderror" id="nota" name="nota" value="{{ old('nota') }}" min="0" max="5" required>
                @error('nota')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Evaluación *</label>
                <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                    <option value="">-- Selecciona un tipo --</option>
                    <option value="Parcial 1" {{ old('tipo') == 'Parcial 1' ? 'selected' : '' }}>Parcial 1</option>
                    <option value="Parcial 2" {{ old('tipo') == 'Parcial 2' ? 'selected' : '' }}>Parcial 2</option>
                    <option value="Parcial 3" {{ old('tipo') == 'Parcial 3' ? 'selected' : '' }}>Parcial 3</option>
                    <option value="Final" {{ old('tipo') == 'Final' ? 'selected' : '' }}>Final</option>
                    <option value="Trabajo Práctico" {{ old('tipo') == 'Trabajo Práctico' ? 'selected' : '' }}>Trabajo Práctico</option>
                </select>
                @error('tipo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de Evaluación *</label>
                <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                @error('fecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
