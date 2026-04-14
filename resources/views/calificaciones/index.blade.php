@extends('layout')

@section('title', 'Calificaciones')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1>Gestión de Calificaciones</h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('calificaciones.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Registrar Calificación
        </a>
    </div>
</div>

@if($calificaciones->isEmpty())
    <div class="alert alert-info">
        No hay calificaciones registradas. <a href="{{ route('calificaciones.create') }}">Registrar una ahora</a>.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Estudiante</th>
                    <th>Materia</th>
                    <th>Tipo</th>
                    <th>Nota</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($calificaciones as $calificacion)
                    <tr>
                        <td>{{ $calificacion->inscripcion->estudiante->nombre }} {{ $calificacion->inscripcion->estudiante->apellido }}</td>
                        <td>{{ $calificacion->inscripcion->materia->nombre }}</td>
                        <td>{{ $calificacion->tipo }}</td>
                        <td>
                            <strong class="
                                @if($calificacion->nota >= 4.0) text-success
                                @elseif($calificacion->nota >= 3.0) text-warning
                                @else text-danger
                                @endif">
                                {{ number_format($calificacion->nota, 2) }}
                            </strong>
                        </td>
                        <td>{{ $calificacion->fecha->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('calificaciones.show', $calificacion->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('calificaciones.edit', $calificacion->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form method="POST" action="{{ route('calificaciones.destroy', $calificacion->id) }}" style="display:inline;">
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
