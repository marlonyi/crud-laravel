@extends('layout')

@section('title', 'Calificación')

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '¿Eliminar calificación?',
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
            <i class="bi bi-award"></i>
            Detalle de Calificación
        </h1>
        <p class="page-subtitle">{{ $calificacion->inscripcion->estudiante->nombre }} - {{ $calificacion->inscripcion->materia->nombre }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('calificaciones.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Grade Display Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-body text-center py-5">
        @php
            $notaClass = $calificacion->nota >= 4.0 ? 'success' : ($calificacion->nota >= 3.0 ? 'warning' : 'danger');
        @endphp
        <div class="mb-3">
            <span class="badge-modern {{ $notaClass }}" style="font-size: 1.25rem; padding: 0.75rem 1.5rem;">
                {{ number_format($calificacion->nota, 2) }}
            </span>
        </div>
        <p class="text-muted mb-0">sobre 5.00</p>
        <p class="mt-2 mb-0">
            @if($calificacion->nota >= 4.0)
                <span class="badge-modern success"><i class="bi bi-emoji-smile"></i> Excelente</span>
            @elseif($calificacion->nota >= 3.0)
                <span class="badge-modern warning"><i class="bi bi-emoji-neutral"></i> Aprobatorio</span>
            @else
                <span class="badge-modern danger"><i class="bi bi-emoji-frown"></i> Reprobado</span>
            @endif
        </p>
    </div>
</div>

<!-- Info Card -->
<div class="content-card animate-fade-in delay-2">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-info-circle"></i>
            Información de la Evaluación
        </h5>
    </div>
    <div class="content-card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-person"></i> Estudiante
                    </span>
                    <span class="detail-value">
                        {{ $calificacion->inscripcion->estudiante->nombre }} {{ $calificacion->inscripcion->estudiante->apellido }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-book"></i> Materia
                    </span>
                    <span class="detail-value">
                        {{ $calificacion->inscripcion->materia->nombre }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-tag"></i> Tipo
                    </span>
                    <span class="detail-value">
                        <span class="badge-modern secondary">{{ $calificacion->tipo }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-calendar"></i> Fecha
                    </span>
                    <span class="detail-value">
                        {{ $calificacion->fecha->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
        @if($calificacion->observaciones)
            <div class="row">
                <div class="col-12">
                    <div class="detail-row">
                        <span class="detail-label">
                            <i class="bi bi-chat-text"></i> Observaciones
                        </span>
                        <span class="detail-value">{{ $calificacion->observaciones }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Actions Card -->
<div class="content-card animate-fade-in delay-3">
    <div class="content-card-body">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('calificaciones.edit', $calificacion->id) }}" class="btn-modern btn-modern-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('calificaciones.index') }}" class="btn-modern btn-modern-secondary">
                <i class="bi bi-list"></i> Ver Todas
            </a>
            <form method="POST" action="{{ route('calificaciones.destroy', $calificacion->id) }}" class="delete-form">
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