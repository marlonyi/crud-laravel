@extends('layout')

@section('title', 'Listado de Estudiantes')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1>Estudiantes</h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('estudiantes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nuevo Estudiante
        </a>
    </div>
</div>

@if($estudiantes->isEmpty())
    <div class="alert alert-info">
        No hay estudiantes registrados. <a href="{{ route('estudiantes.create') }}">Crear uno ahora</a>.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Cédula</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estudiantes as $estudiante)
                    <tr>
                        <td>{{ $estudiante->id }}</td>
                        <td>{{ $estudiante->nombre }}</td>
                        <td>{{ $estudiante->apellido }}</td>
                        <td>{{ $estudiante->email }}</td>
                        <td>{{ $estudiante->cedula }}</td>
                        <td>{{ $estudiante->telefono ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form method="POST" action="{{ route('estudiantes.destroy', $estudiante->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
