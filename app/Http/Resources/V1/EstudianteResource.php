<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EstudianteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'nombre_completo' => $this->nombre_completo,
            'email' => $this->email,
            'cedula' => $this->cedula,
            'fecha_nacimiento' => $this->fecha_nacimiento?->format('Y-m-d'),
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'promedio_general' => $this->promedioGeneral(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'self' => route('api.v1.estudiantes.show', $this->id),
            ],
        ];
    }
}
