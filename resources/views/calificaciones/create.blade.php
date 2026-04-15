@extends('layout')

@section('title', 'Registrar Calificación')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-award"></i>
            Nueva Calificación
        </h1>
        <p class="page-subtitle">Registra una calificación para un estudiante</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('calificaciones.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-pencil-square"></i>
            Información de Calificación
        </h5>
    </div>
    <div class="content-card-body">
        <form method="POST" action="{{ route('calificaciones.store') }}">
            @csrf

            <div class="mb-3">
                <label for="inscripcion_id" class="form-label required">Inscripción (Estudiante - Materia)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-journal-text text-muted"></i>
                    </span>
                    <select class="form-select @error('inscripcion_id') is-invalid @enderror" id="inscripcion_id" name="inscripcion_id" required>
                        <option value="">-- Selecciona una inscripción --</option>
                        @foreach($inscripciones as $inscripcion)
                            <option value="{{ $inscripcion->id }}" {{ old('inscripcion_id') == $inscripcion->id ? 'selected' : '' }}>
                                {{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }} - {{ $inscripcion->materia->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('inscripcion_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="nota" class="form-label required">Nota (0.00 - 5.00)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-star text-muted"></i>
                        </span>
                        <input type="number" step="0.01" class="form-control @error('nota') is-invalid @enderror" id="nota" name="nota" value="{{ old('nota') }}" min="0" max="5" required placeholder="Ej: 4.50">
                    </div>
                    @error('nota')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="tipo" class="form-label required">Tipo de Evaluación</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-tag text-muted"></i>
                        </span>
                        <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                            <option value="">-- Selecciona --</option>
                            <option value="Parcial 1" {{ old('tipo') == 'Parcial 1' ? 'selected' : '' }}>Parcial 1</option>
                            <option value="Parcial 2" {{ old('tipo') == 'Parcial 2' ? 'selected' : '' }}>Parcial 2</option>
                            <option value="Parcial 3" {{ old('tipo') == 'Parcial 3' ? 'selected' : '' }}>Parcial 3</option>
                            <option value="Final" {{ old('tipo') == 'Final' ? 'selected' : '' }}>Final</option>
                            <option value="Trabajo Práctico" {{ old('tipo') == 'Trabajo Práctico' ? 'selected' : '' }}>Trabajo Práctico</option>
                        </select>
                    </div>
                    @error('tipo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="fecha" class="form-label required">Fecha de Evaluación</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-calendar text-muted"></i>
                        </span>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                    </div>
                    @error('fecha')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3" placeholder="Comentarios adicionales sobre la evaluación">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn-modern btn-modern-primary">
                    <i class="bi bi-check-lg"></i> Guardar Calificación
                </button>
                <a href="{{ route('calificaciones.index') }}" class="btn-modern btn-modern-secondary">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection