<?php

namespace Database\Seeders;

use App\Enums\InscripcionEstado;
use App\Models\Calificacion;
use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Materia;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        // Crear 20 estudiantes
        $estudiantes = Estudiante::factory(20)->create();

        // Crear 8 materias
        $materias = Materia::factory(8)->create();

        // Crear 50 inscripciones y sus calificaciones
        $inscripciones = Inscripcion::factory(50)
            ->create()
            ->each(function ($inscripcion) {
                // Cada inscripción tiene 2-4 calificaciones
                $cantidadCalificaciones = rand(2, 4);

                Calificacion::factory()->count($cantidadCalificaciones)->create([
                    'inscripcion_id' => $inscripcion->id,
                ]);
            });

        // Crear inscripciones específicas para demo
        $estudianteDemo = Estudiante::first();
        $materiaDemo = Materia::first();

        if ($estudianteDemo && $materiaDemo) {
            $inscripcionDemo = Inscripcion::factory()->create([
                'estudiante_id' => $estudianteDemo->id,
                'materia_id' => $materiaDemo->id,
                'estado' => InscripcionEstado::ACTIVA->value,
                'fecha_inscripcion' => now()->subMonths(2),
            ]);

            // Crear calificaciones variadas
            Calificacion::factory()->excelente()->create([
                'inscripcion_id' => $inscripcionDemo->id,
                'tipo' => \App\Enums\CalificacionTipo::PARCIAL_1->value,
                'fecha' => now()->subMonths(1),
            ]);

            Calificacion::factory()->aprobada()->create([
                'inscripcion_id' => $inscripcionDemo->id,
                'tipo' => \App\Enums\CalificacionTipo::PARCIAL_2->value,
                'fecha' => now(),
            ]);
        }

        $this->command->info('✓ 20 estudiantes creados');
        $this->command->info('✓ 8 materias creadas');
        $this->command->info('✓ 50+ inscripciones con calificaciones creadas');
    }
}
