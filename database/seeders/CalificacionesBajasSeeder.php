<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Inscripcion;
use App\Enums\CalificacionTipo;
use Illuminate\Database\Seeder;

class CalificacionesBajasSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener inscripciones activas
        $inscripciones = Inscripcion::where('estado', 'activa')->get();

        $calificacionesBajas = [
            ['nota' => 2.5, 'observaciones' => 'No presentó todos los exámenes'],
            ['nota' => 2.8, 'observaciones' => 'Bajo rendimiento en prácticas'],
            ['nota' => 1.5, 'observaciones' => 'Ausencias reiteradas'],
            ['nota' => 2.0, 'observaciones' => 'No entregó tareas'],
            ['nota' => 2.3, 'observaciones' => 'Dificultad con los contenidos'],
            ['nota' => 1.8, 'observaciones' => 'Requiere recuperación'],
            ['nota' => 2.9, 'observaciones' => 'Puede mejorar'],
            ['nota' => 2.2, 'observaciones' => 'Necesita apoyo adicional'],
            ['nota' => 1.0, 'observaciones' => 'No alcanzó los mínimos'],
            ['nota' => 2.7, 'observaciones' => 'Rendimiento insuficiente'],
        ];

        foreach ($calificacionesBajas as $index => $califData) {
            $inscripcion = $inscripciones->random();

            Calificacion::create([
                'inscripcion_id' => $inscripcion->id,
                'nota' => $califData['nota'],
                'tipo' => CalificacionTipo::cases()[array_rand(CalificacionTipo::cases())],
                'fecha' => now()->subDays(rand(1, 15)),
                'observaciones' => $califData['observaciones'],
            ]);
        }

        $this->command->info('✅ 10 calificaciones bajas (< 3.0) creadas exitosamente!');
    }
}
