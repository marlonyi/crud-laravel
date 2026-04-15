@extends('layout')

@section('title', 'Inscripción')

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '¿Eliminar inscripción?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-journal-bookmark"></i>
            Detalles de Inscripción
        </h1>
        <p class="page-subtitle">{{ $inscripcion->estudiante->nombre }} - {{ $inscripcion->materia->nombre }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Info Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-info-circle"></i>
            Información de Inscripción
        </h5>
        <a href="{{ route('inscripciones.edit', $inscripcion->id) }}" class="btn-modern btn-modern-warning btn-modern-sm">
            <i class="bi bi-pencil"></i> Editar
        </a>
    </div>
    <div class="content-card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-person"></i> Estudiante
                    </span>
                    <span class="detail-value">
                        {{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-envelope"></i> Email
                    </span>
                    <span class="detail-value">
                        {{ $inscripcion->estudiante->email }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-book"></i> Materia
                    </span>
                    <span class="detail-value">
                        {{ $inscripcion->materia->nombre }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-hash"></i> Código
                    </span>
                    <span class="detail-value">
                        <span class="badge-modern primary">{{ $inscripcion->materia->codigo }}</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-calendar"></i> Fecha Inscripción
                    </span>
                    <span class="detail-value">
                        {{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-activity"></i> Estado
                    </span>
                    <span class="detail-value">
                        @php
                            $estadoClass = match($inscripcion->estado) {
                                'activa' => 'success',
                                'completada' => 'info',
                                default => 'danger'
                            };
                        @endphp
                        <span class="badge-modern {{ $estadoClass }}">
                            {{ $inscripcion->estado instanceof \App\Enums\InscripcionEstado ? $inscripcion->estado->label() : ucfirst($inscripcion->estado) }}
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grades Card -->
<div class="content-card animate-fade-in delay-2">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-award"></i>
            Calificaciones
        </h5>
        @php $promedio = $inscripcion->promedio(); @endphp
        @if($promedio)
            <span class="badge-modern {{ $promedio >= 4.0 ? 'success' : ($promedio >= 3.0 ? 'warning' : 'danger') }}">
                Promedio: {{ number_format($promedio, 2) }}
            </span>
        @endif
    </div>
    <div class="content-card-body p-0">
        @if($inscripcion->calificaciones->isEmpty())
            <div class="empty-state py-4">
                <i class="bi bi-award" style="font-size: 2rem;"></i>
                <p class="text-muted mb-0">No hay calificaciones registradas</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Nota</th>
                            <th>Fecha</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inscripcion->calificaciones as $cal)
                            <tr>
                                <td>
                                    <span class="badge-modern secondary">{{ $cal->tipo }}</span>
                                </td>
                                <td>
                                    @php
                                        $notaClass = $cal->nota >= 4.0 ? 'success' : ($cal->nota >= 3.0 ? 'warning' : 'danger');
                                    @endphp
                                    <span class="badge-modern {{ $notaClass }}">
                                        {{ number_format($cal->nota, 2) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $cal->fecha->format('d/m/Y') }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('calificaciones.show', $cal->id) }}" class="btn-modern btn-modern-info btn-modern-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Actions Card -->
<div class="content-card animate-fade-in delay-3">
    <div class="content-card-body">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('inscripciones.edit', $inscripcion->id) }}" class="btn-modern btn-modern-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-secondary">
                <i class="bi bi-list"></i> Ver Todas
            </a>
            <form method="POST" action="{{ route('inscripciones.destroy', $inscripcion->id) }}" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modern btn-modern-danger">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection