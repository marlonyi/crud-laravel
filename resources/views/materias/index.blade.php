@extends('layout')

@section('title', 'Materias')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1>Gestión de Materias</h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('materias.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nueva Materia
        </a>
    </div>
</div>

@if($materias->isEmpty())
    <div class="alert alert-info">
        No hay materias registradas. <a href="{{ route('materias.create') }}">Crear una ahora</a>.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Créditos</th>
                    <th>Profesor</th>
                    <th>Horas/Semana</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materias as $materia)
                    <tr>
                        <td><strong>{{ $materia->codigo }}</strong></td>
                        <td>{{ $materia->nombre }}</td>
                        <td>{{ $materia->creditos }}</td>
                        <td>{{ $materia->profesor ?? 'N/A' }}</td>
                        <td>{{ $materia->horas_semana ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('materias.show', $materia->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('materias.edit', $materia->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form method="POST" action="{{ route('materias.destroy', $materia->id) }}" style="display:inline;">
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
