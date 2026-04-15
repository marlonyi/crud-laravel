<?php

namespace App\Http\Requests;

use App\Enums\CalificacionTipo;
use App\Enums\InscripcionEstado;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreCalificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'inscripcion_id' => ['required', 'exists:inscripcions,id'],
            'nota' => ['required', 'numeric', 'min:0', 'max:5'],
            'tipo' => ['required', new Enum(CalificacionTipo::class)],
            'fecha' => ['required', 'date'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $inscripcion = \App\Models\Inscripcion::with('estudiante', 'materia')
                ->find($this->inscripcion_id);

            if ($inscripcion && !$inscripcion->esActiva()) {
                $validator->errors()->add(
                    'inscripcion_id',
                    'No se pueden registrar calificaciones para inscripciones que no están activas.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'inscripcion_id.required' => 'Debe seleccionar una inscripción.',
            'inscripcion_id.exists' => 'La inscripción seleccionada no existe.',
            'nota.required' => 'La nota es obligatoria.',
            'nota.numeric' => 'La nota debe ser un número.',
            'nota.min' => 'La nota mínima es 0.',
            'nota.max' => 'La nota máxima es 5.',
            'tipo.required' => 'El tipo de evaluación es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser válida.',
        ];
    }
}
