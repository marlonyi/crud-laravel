@extends('layout')

@section('title', 'Crear Materia')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Crear Nueva Materia</h1>

        <form method="POST" action="{{ route('materias.store') }}" class="mt-4">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="codigo" class="form-label">Código *</label>
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                @error('codigo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="creditos" class="form-label">Créditos *</label>
                <input type="number" class="form-control @error('creditos') is-invalid @enderror" id="creditos" name="creditos" value="{{ old('creditos') }}" min="1" max="10" required>
                @error('creditos')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="horas_semana" class="form-label">Horas por Semana</label>
                <input type="number" class="form-control @error('horas_semana') is-invalid @enderror" id="horas_semana" name="horas_semana" value="{{ old('horas_semana') }}" min="1">
                @error('horas_semana')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="profesor" class="form-label">Profesor</label>
                <input type="text" class="form-control @error('profesor') is-invalid @enderror" id="profesor" name="profesor" value="{{ old('profesor') }}">
                @error('profesor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('materias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
