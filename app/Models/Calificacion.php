<?php

namespace App\Models;

use App\Enums\CalificacionTipo;
use App\Services\GradeCalculationService;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'inscripcion_id',
        'nota',
        'tipo',
        'fecha',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'nota' => 'decimal:2',
        'tipo' => CalificacionTipo::class,
    ];

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function getNotaFormateadaAttribute(): string
    {
        return number_format((float) $this->nota, 2);
    }

    public function getTipoDisplayAttribute(): string
    {
        return $this->tipo->label();
    }

    public function getColorAttribute(): string
    {
        /** @var GradeCalculationService $service */
        $service = app(GradeCalculationService::class);
        return $service->getColorPorNota((float) $this->nota);
    }

    public function estaAprobada(): bool
    {
        /** @var GradeCalculationService $service */
        $service = app(GradeCalculationService::class);
        return $service->estaAprobada((float) $this->nota);
    }

    public function scopePorTipo(Builder $query, CalificacionTipo $tipo): Builder
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeAprobadas(Builder $query): Builder
    {
        return $query->where('nota', '>=', 3.0);
    }

    public function scopeReprobadas(Builder $query): Builder
    {
        return $query->where('nota', '<', 3.0);
    }

    public function scopeRecientes(Builder $query, int $limit = 10): Builder
    {
        return $query->latest('fecha')->limit($limit);
    }

    public function scopePorRangoNotas(Builder $query, float $min, float $max): Builder
    {
        return $query->whereBetween('nota', [$min, $max]);
    }
}
