<?php

namespace Database\Factories;

use App\Enums\CalificacionTipo;
use App\Models\Inscripcion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalificacionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'inscripcion_id' => Inscripcion::factory(),
            'nota' => $this->faker->randomFloat(2, 0, 5),
            'tipo' => $this->faker->randomElement(CalificacionTipo::cases())->value,
            'fecha' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'observaciones' => $this->faker->optional(0.3)->sentence(8),
        ];
    }

    public function aprobada(): static
    {
        return $this->state(fn (array $attributes) => [
            'nota' => $this->faker->randomFloat(2, 3, 5),
        ]);
    }

    public function reprobada(): static
    {
        return $this->state(fn (array $attributes) => [
            'nota' => $this->faker->randomFloat(2, 0, 2.99),
        ]);
    }

    public function excelente(): static
    {
        return $this->state(fn (array $attributes) => [
            'nota' => $this->faker->randomFloat(2, 4.5, 5),
        ]);
    }
}
