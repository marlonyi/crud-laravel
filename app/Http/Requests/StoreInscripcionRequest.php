<?php

namespace App\Http\Requests;

use App\Enums\InscripcionEstado;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreInscripcionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estudiante_id' => ['required', 'exists:estudiantes,id'],
            'materia_id' => ['required', 'exists:materias,id'],
            'fecha_inscripcion' => ['required', 'date'],
            'estado' => ['required', new Enum(InscripcionEstado::class)],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $exists = \App\Models\Inscripcion::where('estudiante_id', $this->estudiante_id)
                ->where('materia_id', $this->materia_id)
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'materia_id',
                    'El estudiante ya está inscrito en esta materia.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'estudiante_id.required' => 'Debe seleccionar un estudiante.',
            'estudiante_id.exists' => 'El estudiante seleccionado no existe.',
            'materia_id.required' => 'Debe seleccionar una materia.',
            'materia_id.exists' => 'La materia seleccionada no existe.',
            'fecha_inscripcion.required' => 'La fecha de inscripción es obligatoria.',
            'fecha_inscripcion.date' => 'La fecha debe ser válida.',
            'estado.required' => 'El estado es obligatorio.',
        ];
    }
}
