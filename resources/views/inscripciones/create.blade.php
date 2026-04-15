@extends('layout')

@section('title', 'Crear Inscripción')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-journal-bookmark"></i>
            Nueva Inscripción
        </h1>
        <p class="page-subtitle">Inscribe un estudiante en una materia</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-clipboard-plus"></i>
            Información de Inscripción
        </h5>
    </div>
    <div class="content-card-body">
        <form method="POST" action="{{ route('inscripciones.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="estudiante_id" class="form-label required">Estudiante</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <select class="form-select @error('estudiante_id') is-invalid @enderror" id="estudiante_id" name="estudiante_id" required>
                            <option value="">-- Selecciona un estudiante --</option>
                            @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}" {{ old('estudiante_id') == $estudiante->id ? 'selected' : '' }}>
                                    {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('estudiante_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="materia_id" class="form-label required">Materia</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-book text-muted"></i>
                        </span>
                        <select class="form-select @error('materia_id') is-invalid @enderror" id="materia_id" name="materia_id" required>
                            <option value="">-- Selecciona una materia --</option>
                            @foreach($materias as $materia)
                                <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                                    {{ $materia->nombre }} ({{ $materia->codigo }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('materia_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inscripcion" class="form-label required">Fecha de Inscripción</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-calendar text-muted"></i>
                        </span>
                        <input type="date" class="form-control @error('fecha_inscripcion') is-invalid @enderror" id="fecha_inscripcion" name="fecha_inscripcion" value="{{ old('fecha_inscripcion', now()->format('Y-m-d')) }}" required>
                    </div>
                    @error('fecha_inscripcion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label required">Estado</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-activity text-muted"></i>
                        </span>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="activa" {{ old('estado') == 'activa' ? 'selected' : '' }}>Activa</option>
                            <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>
                    @error('estado')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn-modern btn-modern-primary">
                    <i class="bi bi-check-lg"></i> Guardar Inscripción
                </button>
                <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-secondary">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection