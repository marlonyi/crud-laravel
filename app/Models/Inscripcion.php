<?php

namespace App\Models;

use App\Enums\InscripcionEstado;
use App\Services\GradeCalculationService;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inscripcion extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'estudiante_id',
        'materia_id',
        'fecha_inscripcion',
        'estado',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'date',
        'estado' => InscripcionEstado::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (Inscripcion $inscripcion): void {
            if (!$inscripcion->fecha_inscripcion) {
                $inscripcion->fecha_inscripcion = now();
            }
        });
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function calificaciones(): HasMany
    {
        return $this->hasMany(Calificacion::class);
    }

    public function getEstadoDisplayAttribute(): string
    {
        return $this->estado->label();
    }

    public function getEstadoColorAttribute(): string
    {
        return $this->estado->color();
    }

    public function esActiva(): bool
    {
        return $this->estado === InscripcionEstado::ACTIVA;
    }

    public function estaCompletada(): bool
    {
        return $this->estado === InscripcionEstado::COMPLETADA;
    }

    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('estado', InscripcionEstado::ACTIVA);
    }

    public function scopeCompletadas(Builder $query): Builder
    {
        return $query->where('estado', InscripcionEstado::COMPLETADA);
    }

    public function scopeCanceladas(Builder $query): Builder
    {
        return $query->where('estado', InscripcionEstado::CANCELADA);
    }

    public function scopePorEstudiante(Builder $query, int $estudianteId): Builder
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    public function scopePorMateria(Builder $query, int $materiaId): Builder
    {
        return $query->where('materia_id', $materiaId);
    }

    public function scopeRecientes(Builder $query, int $limit = 10): Builder
    {
        return $query->latest('fecha_inscripcion')->limit($limit);
    }

    public function promedio(): ?float
    {
        return app(GradeCalculationService::class)->calcularPromedioInscripcion($this);
    }
}
