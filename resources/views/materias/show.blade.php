@extends('layout')

@section('title', $materia->nombre)

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '¿Eliminar materia?',
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
            <i class="bi bi-book"></i>
            {{ $materia->nombre }}
        </h1>
        <p class="page-subtitle">{{ $materia->codigo }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('materias.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Info Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-journal-text"></i>
            Información de la Materia
        </h5>
        <a href="{{ route('materias.edit', $materia->id) }}" class="btn-modern btn-modern-warning btn-modern-sm">
            <i class="bi bi-pencil"></i> Editar
        </a>
    </div>
    <div class="content-card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-hash"></i> Código
                    </span>
                    <span class="detail-value">
                        <span class="badge-modern primary">{{ $materia->codigo }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-award"></i> Créditos
                    </span>
                    <span class="detail-value">
                        <span class="badge-modern info">{{ $materia->creditos }} créditos</span>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-person-badge"></i> Profesor
                    </span>
                    <span class="detail-value">
                        {{ $materia->profesor ?? 'No asignado' }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-clock"></i> Horas/Semana
                    </span>
                    <span class="detail-value">
                        @if($materia->horas_semana)
                            {{ $materia->horas_semana }} horas
                        @else
                            <span class="badge-modern secondary">N/A</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-text-paragraph"></i> Descripción
                    </span>
                    <span class="detail-value">
                        {{ $materia->descripcion ?? 'Sin descripción' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Students Card -->
<div class="content-card animate-fade-in delay-2">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-people"></i>
            Estudiantes Inscritos
        </h5>
        <span class="badge-modern secondary">{{ $materia->inscripciones->count() }} estudiantes</span>
    </div>
    <div class="content-card-body p-0">
        @if($materia->inscripciones->isEmpty())
            <div class="empty-state py-4">
                <i class="bi bi-people" style="font-size: 2rem;"></i>
                <p class="text-muted mb-0">No hay estudiantes inscritos</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materia->inscripciones as $inscripcion)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ substr($inscripcion->estudiante->nombre, 0, 1) }}
                                        </div>
                                        <span>{{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $estadoClass = match($inscripcion->estado) {
                                            'activa' => 'success',
                                            'completada' => 'info',
                                            default => 'danger'
                                        };
                                    @endphp
                                    <span class="badge-modern {{ $estadoClass }}">
                                        {{ ucfirst($inscripcion->estado) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}
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
            <a href="{{ route('materias.edit', $materia->id) }}" class="btn-modern btn-modern-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('materias.index') }}" class="btn-modern btn-modern-secondary">
                <i class="bi bi-list"></i> Ver Todas
            </a>
            <form method="POST" action="{{ route('materias.destroy', $materia->id) }}" class="delete-form">
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