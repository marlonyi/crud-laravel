@extends('layout')

@section('title', 'Ver Estudiante')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Detalles del Estudiante</h1>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Nombre:</h5>
                        <p>{{ $estudiante->nombre }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Apellido:</h5>
                        <p>{{ $estudiante->apellido }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Email:</h5>
                        <p>{{ $estudiante->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Cédula:</h5>
                        <p>{{ $estudiante->cedula }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Fecha de Nacimiento:</h5>
                        <p>{{ $estudiante->fecha_nacimiento ? $estudiante->fecha_nacimiento->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Teléfono:</h5>
                        <p>{{ $estudiante->telefono ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Dirección:</h5>
                        <p>{{ $estudiante->direccion ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <small class="text-muted">
                            Creado: {{ $estudiante->created_at->format('d/m/Y H:i') }}<br>
                            Actualizado: {{ $estudiante->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Volver</a>
            <form method="POST" action="{{ route('estudiantes.destroy', $estudiante->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este estudiante?')">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
