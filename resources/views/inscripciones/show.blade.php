@extends('layout')

@section('title', 'Inscripción')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Detalles de la Inscripción</h1>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Estudiante:</h5>
                        <p>{{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Email:</h5>
                        <p>{{ $inscripcion->estudiante->email }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Materia:</h5>
                        <p>{{ $inscripcion->materia->nombre }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Código:</h5>
                        <p>{{ $inscripcion->materia->codigo }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Fecha Inscripción:</h5>
                        <p>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Estado:</h5>
                        <p>
                            <span class="badge 
                                @if($inscripcion->estado === 'activa') bg-success
                                @elseif($inscripcion->estado === 'completada') bg-info
                                @else bg-danger
                                @endif">
                                {{ ucfirst($inscripcion->estado) }}
                            </span>
                        </p>
                    </div>
                </div>

                <hr>
                <h5>Calificaciones</h5>
                @if($inscripcion->calificaciones->isEmpty())
                    <p class="text-muted">No hay calificaciones registradas</p>
                @else
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Nota</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inscripcion->calificaciones as $cal)
                                <tr>
                                    <td>{{ $cal->tipo }}</td>
                                    <td><strong>{{ number_format($cal->nota, 2) }}</strong></td>
                                    <td>{{ $cal->fecha->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p><strong>Promedio: {{ number_format($inscripcion->promedio(), 2) }}</strong></p>
                @endif
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('inscripciones.edit', $inscripcion->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary">Volver</a>
            <form method="POST" action="{{ route('inscripciones.destroy', $inscripcion->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
