<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMateriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'codigo' => ['required', 'string', 'max:50', 'unique:materias,codigo'],
            'creditos' => ['required', 'integer', 'min:1', 'max:10'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'horas_semana' => ['nullable', 'integer', 'min:1', 'max:40'],
            'profesor' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'codigo.required' => 'El código de la materia es obligatorio.',
            'codigo.unique' => 'Este código de materia ya existe.',
            'creditos.required' => 'Los créditos son obligatorios.',
            'creditos.integer' => 'Los créditos deben ser un número entero.',
            'creditos.min' => 'Los créditos deben ser al menos 1.',
            'creditos.max' => 'Los créditos no pueden ser mayores a 10.',
            'profesor.required' => 'El nombre del profesor es obligatorio.',
        ];
    }
}
