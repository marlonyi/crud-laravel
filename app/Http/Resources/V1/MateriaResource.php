<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MateriaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'codigo' => $this->codigo,
            'nombre_con_codigo' => $this->nombre_con_codigo,
            'creditos' => $this->creditos,
            'descripcion' => $this->descripcion,
            'horas_semana' => $this->horas_semana,
            'profesor' => $this->profesor,
            'total_inscritos' => $this->inscripciones_count ?? 0,
            'promedio_general' => $this->calcularPromedioGeneral(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'self' => route('api.v1.materias.show', $this->id),
            ],
        ];
    }
}
