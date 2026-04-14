@extends('layout')

@section('title', 'Inscripciones')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1>Gestión de Inscripciones</h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nueva Inscripción
        </a>
    </div>
</div>

@if($inscripciones->isEmpty())
    <div class="alert alert-info">
        No hay inscripciones. <a href="{{ route('inscripciones.create') }}">Crear una ahora</a>.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Estudiante</th>
                    <th>Materia</th>
                    <th>Fecha Inscripción</th>
                    <th>Estado</th>
                    <th>Promedio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscripciones as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}</td>
                        <td>{{ $inscripcion->materia->nombre }} ({{ $inscripcion->materia->codigo }})</td>
                        <td>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge 
                                @if($inscripcion->estado === 'activa') bg-success
                                @elseif($inscripcion->estado === 'completada') bg-info
                                @else bg-danger
                                @endif">
                                {{ ucfirst($inscripcion->estado) }}
                            </span>
                        </td>
                        <td>
                            @php $promedio = $inscripcion->promedio(); @endphp
                            @if($promedio)
                                <strong>{{ number_format($promedio, 2) }}</strong>
                            @else
                                Sin notas
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('inscripciones.show', $inscripcion->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('inscripciones.edit', $inscripcion->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form method="POST" action="{{ route('inscripciones.destroy', $inscripcion->id) }}" style="display:inline;">
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
