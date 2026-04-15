<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstudianteFactory extends Factory
{
    public function definition(): array
    {
        $nombres = ['Carlos', 'María', 'José', 'Ana', 'Luis', 'Pedro', 'Carmen', 'Jorge', 'Laura', 'Miguel'];
        $apellidos = ['García', 'Rodríguez', 'Martínez', 'López', 'González', 'Pérez', 'Sánchez', 'Ramírez', 'Torres', 'Flores'];

        $nombre = $this->faker->randomElement($nombres);
        $apellido = $this->faker->randomElement($apellidos);

        return [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => strtolower($nombre) . '.' . strtolower($apellido) . $this->faker->unique()->numberBetween(1, 999) . '@email.com',
            'cedula' => $this->faker->unique()->numerify('##########'),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-25 years', '-18 years'),
            'telefono' => $this->faker->phoneNumber,
            'direccion' => $this->faker->address,
        ];
    }
}
