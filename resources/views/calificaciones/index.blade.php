@extends('layout')

@section('title', 'Calificaciones')

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formElement = this;
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
            <i class="bi bi-award-fill"></i>
            Calificaciones
        </h1>
        <p class="page-subtitle">Gestión de calificaciones del sistema universitario</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('calificaciones.create') }}" class="btn-modern btn-modern-primary">
            <i class="bi bi-plus-lg"></i> Registrar Calificación
        </a>
    </div>
</div>

<!-- Content Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-body p-0">
        @if($calificaciones->isEmpty())
            <div class="empty-state">
                <i class="bi bi-award"></i>
                <h5>No hay calificaciones registradas</h5>
                <p>Comienza registrando la primera calificación</p>
                <a href="{{ route('calificaciones.create') }}" class="btn-modern btn-modern-primary mt-3">
                    <i class="bi bi-plus-lg"></i> Registrar Calificación
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person"></i> Estudiante</th>
                            <th><i class="bi bi-book"></i> Materia</th>
                            <th><i class="bi bi-tag"></i> Tipo</th>
                            <th><i class="bi bi-star"></i> Nota</th>
                            <th><i class="bi bi-calendar"></i> Fecha</th>
                            <th class="text-end"><i class="bi bi-gear"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calificaciones as $calificacion)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ substr($calificacion->inscripcion->estudiante->nombre, 0, 1) }}
                                        </div>
                                        <span>{{ $calificacion->inscripcion->estudiante->nombre }} {{ $calificacion->inscripcion->estudiante->apellido }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $calificacion->inscripcion->materia->nombre }}</span>
                                </td>
                                <td>
                                    <span class="badge-modern secondary">{{ $calificacion->tipo }}</span>
                                </td>
                                <td>
                                    @php
                                        $notaClass = $calificacion->nota >= 4.0 ? 'success' : ($calificacion->nota >= 3.0 ? 'warning' : 'danger');
                                    @endphp
                                    <span class="badge-modern {{ $notaClass }}" style="font-size: 0.9rem; padding: 0.4rem 0.8rem;">
                                        {{ number_format($calificacion->nota, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span>{{ $calificacion->fecha->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('calificaciones.show', $calificacion->id) }}" class="btn-modern btn-modern-info btn-modern-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('calificaciones.edit', $calificacion->id) }}" class="btn-modern btn-modern-warning btn-modern-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('calificaciones.destroy', $calificacion->id) }}" class="delete-form">
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

            @if($calificaciones->hasPages())
                <div class="p-3 border-top">
                    {{ $calificaciones->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection