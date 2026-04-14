@extends('layout')

@section('title', 'Editar Inscripción')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Editar Inscripción</h1>

        <form method="POST" action="{{ route('inscripciones.update', $inscripcion->id) }}" class="mt-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Estudiante</label>
                <input type="text" class="form-control" disabled value="{{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Materia</label>
                <input type="text" class="form-control" disabled value="{{ $inscripcion->materia->nombre }} ({{ $inscripcion->materia->codigo }})">
            </div>

            <div class="mb-3">
                <label for="fecha_inscripcion" class="form-label">Fecha de Inscripción *</label>
                <input type="date" class="form-control @error('fecha_inscripcion') is-invalid @enderror" id="fecha_inscripcion" name="fecha_inscripcion" value="{{ old('fecha_inscripcion', $inscripcion->fecha_inscripcion->format('Y-m-d')) }}" required>
                @error('fecha_inscripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado *</label>
                <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                    <option value="activa" {{ old('estado', $inscripcion->estado) == 'activa' ? 'selected' : '' }}>Activa</option>
                    <option value="completada" {{ old('estado', $inscripcion->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada" {{ old('estado', $inscripcion->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
                @error('estado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
