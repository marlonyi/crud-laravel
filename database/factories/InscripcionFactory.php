<?php

namespace Database\Factories;

use App\Enums\InscripcionEstado;
use App\Models\Estudiante;
use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscripcionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'estudiante_id' => Estudiante::factory(),
            'materia_id' => Materia::factory(),
            'fecha_inscripcion' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'estado' => $this->faker->randomElement(InscripcionEstado::cases())->value,
        ];
    }

    public function activa(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => InscripcionEstado::ACTIVA->value,
        ]);
    }

    public function completada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => InscripcionEstado::COMPLETADA->value,
        ]);
    }

    public function cancelada(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => InscripcionEstado::CANCELADA->value,
        ]);
    }
}
