@extends('layout')

@section('title', 'Inscripciones')

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formElement = this;
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
                        formElement.submit();
                    }
                });
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
            <i class="bi bi-journal-bookmark-fill"></i>
            Inscripciones
        </h1>
        <p class="page-subtitle">Gestión de inscripciones de estudiantes en materias</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('inscripciones.create') }}" class="btn-modern btn-modern-primary">
            <i class="bi bi-plus-lg"></i> Nueva Inscripción
        </a>
    </div>
</div>

<!-- Content Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-body p-0">
        @if($inscripciones->isEmpty())
            <div class="empty-state">
                <i class="bi bi-journal-bookmark"></i>
                <h5>No hay inscripciones registradas</h5>
                <p>Comienza inscribiendo un estudiante en una materia</p>
                <a href="{{ route('inscripciones.create') }}" class="btn-modern btn-modern-primary mt-3">
                    <i class="bi bi-plus-lg"></i> Nueva Inscripción
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person"></i> Estudiante</th>
                            <th><i class="bi bi-book"></i> Materia</th>
                            <th><i class="bi bi-calendar"></i> Fecha Inscripción</th>
                            <th><i class="bi bi-activity"></i> Estado</th>
                            <th><i class="bi bi-graph-up"></i> Promedio</th>
                            <th class="text-end"><i class="bi bi-gear"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inscripciones as $inscripcion)
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
                                    <div>
                                        <span class="fw-medium">{{ $inscripcion->materia->nombre }}</span>
                                        <small class="text-muted d-block">{{ $inscripcion->materia->codigo }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</span>
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
                                        {{ $inscripcion->estado instanceof \App\Enums\InscripcionEstado ? $inscripcion->estado->label() : ucfirst($inscripcion->estado) }}
                                    </span>
                                </td>
                                <td>
                                    @php $promedio = $inscripcion->promedio(); @endphp
                                    @if($promedio)
                                        @php $notaClass = $promedio >= 4.0 ? 'success' : ($promedio >= 3.0 ? 'warning' : 'danger'); @endphp
                                        <span class="badge-modern {{ $notaClass }}" style="font-size: 0.9rem;">
                                            {{ number_format($promedio, 2) }}
                                        </span>
                                    @else
                                        <span class="badge-modern secondary">Sin notas</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('inscripciones.show', $inscripcion->id) }}" class="btn-modern btn-modern-info btn-modern-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('inscripciones.edit', $inscripcion->id) }}" class="btn-modern btn-modern-warning btn-modern-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('inscripciones.destroy', $inscripcion->id) }}" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modern btn-modern-danger btn-modern-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($inscripciones->hasPages())
                <div class="p-3 border-top">
                    {{ $inscripciones->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection