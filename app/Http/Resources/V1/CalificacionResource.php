<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalificacionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'inscripcion' => new InscripcionResource($this->whenLoaded('inscripcion')),
            'nota' => (float) $this->nota,
            'nota_formateada' => $this->nota_formateada,
            'tipo' => $this->tipo->value,
            'tipo_display' => $this->tipo->label(),
            'fecha' => $this->fecha?->format('Y-m-d'),
            'observaciones' => $this->observaciones,
            'aprobada' => $this->estaAprobada(),
            'color' => $this->color,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'self' => route('api.v1.calificaciones.show', $this->id),
            ],
        ];
    }
}
