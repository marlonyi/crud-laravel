@extends('layout')

@section('title', $materia->nombre)

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>{{ $materia->nombre }}</h1>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Código:</h5>
                        <p><strong>{{ $materia->codigo }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Créditos:</h5>
                        <p>{{ $materia->creditos }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Profesor:</h5>
                        <p>{{ $materia->profesor ?? 'No asignado' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Horas por Semana:</h5>
                        <p>{{ $materia->horas_semana ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Descripción:</h5>
                        <p>{{ $materia->descripcion ?? 'Sin descripción' }}</p>
                    </div>
                </div>

                <hr>

                <h5>Estudiantes Inscritos ({{ $materia->inscripciones->count() }})</h5>
                @if($materia->inscripciones->isEmpty())
                    <p class="text-muted">No hay estudiantes inscritos</p>
                @else
                    <ul class="list-group">
                        @foreach($materia->inscripciones as $inscripcion)
                            <li class="list-group-item">
                                <strong>{{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}</strong>
                                <span class="badge bg-secondary">{{ $inscripcion->estado }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('materias.edit', $materia->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('materias.index') }}" class="btn btn-secondary">Volver</a>
            <form method="POST" action="{{ route('materias.destroy', $materia->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
