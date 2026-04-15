<?php

namespace App\Http\Requests;

use App\Enums\CalificacionTipo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateCalificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nota' => ['required', 'numeric', 'min:0', 'max:5'],
            'tipo' => ['required', new Enum(CalificacionTipo::class)],
            'fecha' => ['required', 'date'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
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
