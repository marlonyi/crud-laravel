<?php

namespace App\Models;

use App\Services\GradeCalculationService;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'cedula',
        'fecha_nacimiento',
        'telefono',
        'direccion',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function scopeBuscar(Builder $query, string $termino): Builder
    {
        return $query->where(function ($q) use ($termino) {
            $q->where('nombre', 'like', "%{$termino}%")
              ->orWhere('apellido', 'like', "%{$termino}%")
              ->orWhere('email', 'like', "%{$termino}%")
              ->orWhere('cedula', 'like', "%{$termino}%");
        });
    }

    public function scopeRecientes(Builder $query, int $limit = 10): Builder
    {
        return $query->latest('created_at')->limit($limit);
    }

    public function scopeConPromedio(Builder $query): Builder
    {
        return $query->withCount(['inscripciones as promedio_general' => function (Builder $query): void {
            $query->select(\DB::raw('ROUND(AVG(calificacions.nota), 2)'))
                  ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id');
        }]);
    }

    public function promedioGeneral(): float
    {
        return app(GradeCalculationService::class)->calcularPromedioGeneral($this);
    }
}
