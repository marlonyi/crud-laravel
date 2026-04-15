<?php

namespace App\Http\Requests;

use App\Enums\InscripcionEstado;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class UpdateInscripcionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $inscripcionId = $this->route('inscripcion')->id;

        return [
            'fecha_inscripcion' => ['required', 'date'],
            'estado' => ['required', new Enum(InscripcionEstado::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_inscripcion.required' => 'La fecha de inscripción es obligatoria.',
            'fecha_inscripcion.date' => 'La fecha debe ser válida.',
            'estado.required' => 'El estado es obligatorio.',
        ];
    }
}
