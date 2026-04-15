<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MateriaFactory extends Factory
{
    public function definition(): array
    {
        $materias = [
            ['nombre' => 'Matemáticas I', 'codigo' => 'MAT101', 'profesor' => 'Dr. Roberto Méndez'],
            ['nombre' => 'Física I', 'codigo' => 'FIS201', 'profesor' => 'Dra. Patricia Vargas'],
            ['nombre' => 'Programación I', 'codigo' => 'PRO301', 'profesor' => 'Ing. Andrés Castro'],
            ['nombre' => 'Química General', 'codigo' => 'QUI102', 'profesor' => 'Dra. Rosa Morales'],
            ['nombre' => 'Estadística', 'codigo' => 'EST202', 'profesor' => 'Dr. Fernando Ruiz'],
            ['nombre' => 'Cálculo I', 'codigo' => 'CAL103', 'profesor' => 'Dr. Manuel Herrera'],
            ['nombre' => 'Álgebra Lineal', 'codigo' => 'ALG104', 'profesor' => 'Dra. Isabel Medina'],
            ['nombre' => 'Base de Datos', 'codigo' => 'BD305', 'profesor' => 'Ing. Ricardo Silva'],
        ];

        $materia = $this->faker->randomElement($materias);

        return [
            'nombre' => $materia['nombre'],
            'codigo' => $materia['codigo'] . $this->faker->unique()->numberBetween(1, 99),
            'creditos' => $this->faker->numberBetween(3, 6),
            'descripcion' => $this->faker->sentence(10),
            'horas_semana' => $this->faker->numberBetween(2, 6),
            'profesor' => $materia['profesor'],
        ];
    }
}
