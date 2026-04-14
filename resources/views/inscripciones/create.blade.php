@extends('layout')

@section('title', 'Crear Inscripción')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Nueva Inscripción</h1>

        <form method="POST" action="{{ route('inscripciones.store') }}" class="mt-4">
            @csrf

            <div class="mb-3">
                <label for="estudiante_id" class="form-label">Estudiante *</label>
                <select class="form-control @error('estudiante_id') is-invalid @enderror" id="estudiante_id" name="estudiante_id" required>
                    <option value="">-- Selecciona un estudiante --</option>
                    @foreach($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}" {{ old('estudiante_id') == $estudiante->id ? 'selected' : '' }}>
                            {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                        </option>
                    @endforeach
                </select>
                @error('estudiante_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="materia_id" class="form-label">Materia *</label>
                <select class="form-control @error('materia_id') is-invalid @enderror" id="materia_id" name="materia_id" required>
                    <option value="">-- Selecciona una materia --</option>
                    @foreach($materias as $materia)
                        <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                            {{ $materia->nombre }} ({{ $materia->codigo }})
                        </option>
                    @endforeach
                </select>
                @error('materia_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="fecha_inscripcion" class="form-label">Fecha de Inscripción *</label>
                <input type="date" class="form-control @error('fecha_inscripcion') is-invalid @enderror" id="fecha_inscripcion" name="fecha_inscripcion" value="{{ old('fecha_inscripcion') }}" required>
                @error('fecha_inscripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado *</label>
                <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                    <option value="activa" {{ old('estado') == 'activa' ? 'selected' : '' }}>Activa</option>
                    <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
                @error('estado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        @if($errors->any())
            <div class="alert alert-danger mt-4">
                <strong>Error:</strong> {{ $errors->first() }}
            </div>
        @endif
    </div>
</div>
@endsection
