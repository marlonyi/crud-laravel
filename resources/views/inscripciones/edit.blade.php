@extends('layout')

@section('title', 'Editar Inscripción')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-pencil-square"></i>
            Editar Inscripción
        </h1>
        <p class="page-subtitle">Modifica el estado de la inscripción</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Info Card -->
<div class="content-card animate-fade-in delay-1 mb-3">
    <div class="content-card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-person"></i> Estudiante
                    </span>
                    <span class="detail-value">
                        {{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-book"></i> Materia
                    </span>
                    <span class="detail-value">
                        {{ $inscripcion->materia->nombre }} ({{ $inscripcion->materia->codigo }})
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="content-card animate-fade-in delay-2">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-clipboard-check"></i>
            Actualizar Estado
        </h5>
    </div>
    <div class="content-card-body">
        <form method="POST" action="{{ route('inscripciones.update', $inscripcion->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inscripcion" class="form-label required">Fecha de Inscripción</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-calendar text-muted"></i>
                        </span>
                        <input type="date" class="form-control @error('fecha_inscripcion') is-invalid @enderror" id="fecha_inscripcion" name="fecha_inscripcion" value="{{ old('fecha_inscripcion', $inscripcion->fecha_inscripcion->format('Y-m-d')) }}" required>
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
                            <option value="activa" {{ old('estado', $inscripcion->estado) == 'activa' ? 'selected' : '' }}>Activa</option>
                            <option value="completada" {{ old('estado', $inscripcion->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelada" {{ old('estado', $inscripcion->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>
                    @error('estado')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn-modern btn-modern-primary">
                    <i class="bi bi-check-lg"></i> Guardar Cambios
                </button>
                <a href="{{ route('inscripciones.show', $inscripcion->id) }}" class="btn-modern btn-modern-info">
                    <i class="bi bi-eye"></i> Ver Detalles
                </a>
                <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-secondary">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection