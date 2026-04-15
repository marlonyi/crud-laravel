<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'nombre',
        'codigo',
        'creditos',
        'descripcion',
        'horas_semana',
        'profesor',
    ];

    protected $casts = [
        'creditos' => 'integer',
        'horas_semana' => 'integer',
    ];

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function getNombreConCodigoAttribute(): string
    {
        return "{$this->codigo} - {$this->nombre}";
    }

    public function scopeBuscar(Builder $query, string $termino): Builder
    {
        return $query->where(function ($q) use ($termino) {
            $q->where('nombre', 'like', "%{$termino}%")
              ->orWhere('codigo', 'like', "%{$termino}%")
              ->orWhere('profesor', 'like', "%{$termino}%");
        });
    }

    public function scopePopulares(Builder $query, int $limit = 5): Builder
    {
        return $query->withCount(['inscripciones'])
                     ->orderByDesc('inscripciones_count')
                     ->limit($limit);
    }

    public function scopePorProfesor(Builder $query, string $profesor): Builder
    {
        return $query->where('profesor', 'like', "%{$profesor}%");
    }

    public function calcularPromedioGeneral(): ?float
    {
        $promedio = $this->inscripciones()
            ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
            ->avg('calificacions.nota');

        return $promedio ? round((float) $promedio, 2) : null;
    }
}
