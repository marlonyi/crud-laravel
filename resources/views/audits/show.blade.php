@extends('layout')

@section('title', 'Detalle de Auditoría')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-shield-check"></i>
            Auditoría #{{ $audit->id }}
        </h1>
        <p class="page-subtitle">Información detallada del registro</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('audits.index') }}" class="btn-modern btn-modern-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- General Info -->
    <div class="col-lg-6">
        <div class="content-card animate-fade-in delay-1 h-100">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-info-circle"></i>
                    Información General
                </h5>
            </div>
            <div class="content-card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="bi bi-lightning"></i> Acción
                            </span>
                            <span class="detail-value">
                                @php
                                    $actionConfig = [
                                        'created' => ['class' => 'success', 'icon' => 'bi-plus-circle', 'label' => 'Creado'],
                                        'updated' => ['class' => 'warning', 'icon' => 'bi-pencil', 'label' => 'Actualizado'],
                                        'deleted' => ['class' => 'danger', 'icon' => 'bi-trash', 'label' => 'Eliminado'],
                                    ];
                                    $config = $actionConfig[$audit->action] ?? ['class' => 'secondary', 'icon' => 'bi-circle', 'label' => $audit->action];
                                @endphp
                                <span class="badge-modern {{ $config['class'] }}">
                                    <i class="bi {{ $config['icon'] }}"></i>
                                    {{ $config['label'] }}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="bi bi-file-earmark"></i> Modelo
                            </span>
                            <span class="detail-value">
                                <span class="badge-modern primary">{{ class_basename($audit->auditable_type) }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="bi bi-hash"></i> ID Registro
                            </span>
                            <span class="detail-value">
                                <code>#{{ $audit->auditable_id }}</code>
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="bi bi-calendar"></i> Fecha
                            </span>
                            <span class="detail-value">
                                {{ $audit->created_at->format('d/m/Y') }}
                                <small class="text-muted d-block">{{ $audit->created_at->format('H:i:s') }}</small>
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="bi bi-person"></i> Usuario
                            </span>
                            <span class="detail-value">
                                @if($audit->user)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar" style="width: 28px; height: 28px; font-size: 0.7rem;">
                                            {{ substr($audit->user->name, 0, 2) }}
                                        </div>
                                        <span>{{ $audit->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted"><i class="bi bi-robot"></i> Sistema</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="bi bi-pc-display"></i> IP
                            </span>
                            <span class="detail-value">
                                <code>{{ $audit->ip_address ?? 'N/A' }}</code>
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="bi bi-browser-chrome"></i> User Agent
                            </span>
                            <span class="detail-value text-break" style="font-size: 0.8rem;">
                                <code>{{ $audit->user_agent ?? 'N/A' }}</code>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Old Values -->
    <div class="col-lg-6">
        <div class="content-card animate-fade-in delay-2 h-100">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-arrow-left-circle"></i>
                    Valores Anteriores
                </h5>
            </div>
            <div class="content-card-body p-0">
                @if($audit->old_values)
                    <pre class="bg-dark text-light p-3 rounded-0 mb-0" style="max-height: 350px; overflow: auto;"><code>{{ json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                @else
                    <div class="empty-state py-5">
                        <i class="bi bi-file-earmark-x" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0 mt-2">No hay valores anteriores</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- New Values -->
    <div class="col-12">
        <div class="content-card animate-fade-in delay-3">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-arrow-right-circle"></i>
                    Valores Nuevos / Cambios
                </h5>
            </div>
            <div class="content-card-body p-0">
                @if($audit->new_values)
                    <pre class="bg-dark text-light p-3 rounded-0 mb-0" style="max-height: 400px; overflow: auto;"><code>{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                @else
                    <div class="empty-state py-4">
                        <i class="bi bi-file-earmark-x" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0 mt-2">No hay valores nuevos</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Timeline -->
<div class="content-card animate-fade-in delay-4 mt-3">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-clock-history"></i>
            Línea de Tiempo
        </h5>
    </div>
    <div class="content-card-body">
        <div class="d-flex align-items-center gap-3">
            <div class="stat-card-icon" style="width: 48px; height: 48px;">
                <i class="bi {{ $config['icon'] }}"></i>
            </div>
            <div>
                <div class="fw-semibold">{{ $config['label'] }} de {{ class_basename($audit->auditable_type) }} #{{ $audit->auditable_id }}</div>
                <small class="text-muted">
                    {{ $audit->created_at->diffForHumans() }} • {{ $audit->created_at->format('d/m/Y H:i:s') }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection