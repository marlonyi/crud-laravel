@extends('layout')

@section('title', $estudiante->nombre . ' ' . $estudiante->apellido)

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '¿Eliminar estudiante?',
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
            <i class="bi bi-person-badge"></i>
            {{ $estudiante->nombre }} {{ $estudiante->apellido }}
        </h1>
        <p class="page-subtitle">Detalles del estudiante</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('estudiantes.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Info Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-person-vcard"></i>
            Información Personal
        </h5>
        <div class="d-flex gap-2">
            <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn-modern btn-modern-warning btn-modern-sm">
                <i class="bi bi-pencil"></i> Editar
            </a>
        </div>
    </div>
    <div class="content-card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-person"></i> Nombre
                    </span>
                    <span class="detail-value">{{ $estudiante->nombre }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-person"></i> Apellido
                    </span>
                    <span class="detail-value">{{ $estudiante->apellido }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-envelope"></i> Email
                    </span>
                    <span class="detail-value">
                        <a href="mailto:{{ $estudiante->email }}">{{ $estudiante->email }}</a>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-card-text"></i> Cédula
                    </span>
                    <span class="detail-value">
                        <code class="bg-light px-2 py-1 rounded">{{ $estudiante->cedula }}</code>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-calendar"></i> Fecha Nacimiento
                    </span>
                    <span class="detail-value">
                        {{ $estudiante->fecha_nacimiento ? $estudiante->fecha_nacimiento->format('d/m/Y') : 'N/A' }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="bi bi-telephone"></i> Teléfono
                    </span>
                    <span class="detail-value">
                        @if($estudiante->telefono)
                            <a href="tel:{{ $estudiante->telefono }}">{{ $estudiante->telefono }}</a>
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
                        <i class="bi bi-geo-alt"></i> Dirección
                    </span>
                    <span class="detail-value">{{ $estudiante->direccion ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timestamps Card -->
<div class="content-card animate-fade-in delay-2">
    <div class="content-card-body py-3">
        <div class="d-flex gap-4 text-muted small">
            <span>
                <i class="bi bi-clock"></i> Creado: {{ $estudiante->created_at->format('d/m/Y H:i') }}
            </span>
            <span>
                <i class="bi bi-arrow-repeat"></i> Actualizado: {{ $estudiante->updated_at->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>
</div>

<!-- Actions Card -->
<div class="content-card animate-fade-in delay-3">
    <div class="content-card-body">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn-modern btn-modern-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('estudiantes.index') }}" class="btn-modern btn-modern-secondary">
                <i class="bi bi-list"></i> Ver Todos
            </a>
            <form method="POST" action="{{ route('estudiantes.destroy', $estudiante->id) }}" class="delete-form">
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