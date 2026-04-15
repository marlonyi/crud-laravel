@extends('layout')

@section('title', 'Crear Materia')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-book"></i>
            Nueva Materia
        </h1>
        <p class="page-subtitle">Registra una nueva materia en el sistema</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('materias.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-journal-text"></i>
            Información de la Materia
        </h5>
    </div>
    <div class="content-card-body">
        <form method="POST" action="{{ route('materias.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label required">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-bookmark text-muted"></i>
                        </span>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Nombre de la materia">
                    </div>
                    @error('nombre')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="codigo" class="form-label required">Código</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-hash text-muted"></i>
                        </span>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo') }}" required placeholder="Ej: MAT-101">
                    </div>
                    @error('codigo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="creditos" class="form-label required">Créditos</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-award text-muted"></i>
                        </span>
                        <input type="number" class="form-control @error('creditos') is-invalid @enderror" id="creditos" name="creditos" value="{{ old('creditos') }}" min="1" max="10" required>
                    </div>
                    @error('creditos')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="horas_semana" class="form-label">Horas por Semana</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-clock text-muted"></i>
                        </span>
                        <input type="number" class="form-control @error('horas_semana') is-invalid @enderror" id="horas_semana" name="horas_semana" value="{{ old('horas_semana') }}" min="1" placeholder="Ej: 4">
                    </div>
                    @error('horas_semana')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="profesor" class="form-label">Profesor</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-person-badge text-muted"></i>
                        </span>
                        <input type="text" class="form-control @error('profesor') is-invalid @enderror" id="profesor" name="profesor" value="{{ old('profesor') }}" placeholder="Nombre del profesor">
                    </div>
                    @error('profesor')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" placeholder="Descripción de la materia">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn-modern btn-modern-primary">
                    <i class="bi bi-check-lg"></i> Guardar Materia
                </button>
                <a href="{{ route('materias.index') }}" class="btn-modern btn-modern-secondary">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection