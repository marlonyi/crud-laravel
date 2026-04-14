@extends('layout')

@section('title', 'Calificación')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Detalles de Calificación</h1>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Estudiante:</h5>
                        <p>{{ $calificacion->inscripcion->estudiante->nombre }} {{ $calificacion->inscripcion->estudiante->apellido }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Materia:</h5>
                        <p>{{ $calificacion->inscripcion->materia->nombre }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Nota:</h5>
                        <p>
                            <strong class="h4
                                @if($calificacion->nota >= 4.0) text-success
                                @elseif($calificacion->nota >= 3.0) text-warning
                                @else text-danger
                                @endif">
                                {{ number_format($calificacion->nota, 2) }}/5.00
                            </strong>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Tipo:</h5>
                        <p>{{ $calificacion->tipo }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Fecha:</h5>
                        <p>{{ $calificacion->fecha->format('d/m/Y') }}</p>
                    </div>
                </div>

                @if($calificacion->observaciones)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Observaciones:</h5>
                            <p>{{ $calificacion->observaciones }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('calificaciones.edit', $calificacion->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Volver</a>
            <form method="POST" action="{{ route('calificaciones.destroy', $calificacion->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
