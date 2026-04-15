<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InscripcionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'estudiante' => new EstudianteResource($this->whenLoaded('estudiante')),
            'materia' => new MateriaResource($this->whenLoaded('materia')),
            'fecha_inscripcion' => $this->fecha_inscripcion?->format('Y-m-d'),
            'estado' => $this->estado->value,
            'estado_display' => $this->estado->label(),
            'promedio' => $this->promedio(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'self' => route('api.v1.inscripciones.show', $this->id),
            ],
        ];
    }
}
