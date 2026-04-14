@extends('layout')

@section('title', 'Editar Calificación')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Editar Calificación</h1>

        <form method="POST" action="{{ route('calificaciones.update', $calificacion->id) }}" class="mt-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Estudiante - Materia</label>
                <input type="text" class="form-control" disabled value="{{ $calificacion->inscripcion->estudiante->nombre }} - {{ $calificacion->inscripcion->materia->nombre }}">
            </div>

            <div class="mb-3">
                <label for="nota" class="form-label">Nota (0.00 - 5.00) *</label>
                <input type="number" step="0.01" class="form-control @error('nota') is-invalid @enderror" id="nota" name="nota" value="{{ old('nota', $calificacion->nota) }}" min="0" max="5" required>
                @error('nota')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Evaluación *</label>
                <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                    <option value="Parcial 1" {{ old('tipo', $calificacion->tipo) == 'Parcial 1' ? 'selected' : '' }}>Parcial 1</option>
                    <option value="Parcial 2" {{ old('tipo', $calificacion->tipo) == 'Parcial 2' ? 'selected' : '' }}>Parcial 2</option>
                    <option value="Parcial 3" {{ old('tipo', $calificacion->tipo) == 'Parcial 3' ? 'selected' : '' }}>Parcial 3</option>
                    <option value="Final" {{ old('tipo', $calificacion->tipo) == 'Final' ? 'selected' : '' }}>Final</option>
                    <option value="Trabajo Práctico" {{ old('tipo', $calificacion->tipo) == 'Trabajo Práctico' ? 'selected' : '' }}>Trabajo Práctico</option>
                </select>
                @error('tipo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de Evaluación *</label>
                <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha', $calificacion->fecha->format('Y-m-d')) }}" required>
                @error('fecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $calificacion->observaciones) }}</textarea>
                @error('observaciones')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
