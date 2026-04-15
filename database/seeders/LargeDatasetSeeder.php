<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LargeDatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "\n🧹 Limpiando datos previos...\n";
        
        // Limpiar todas las tablas
        DB::statement('TRUNCATE TABLE calificacions CASCADE');
        DB::statement('TRUNCATE TABLE inscripcions CASCADE');
        DB::statement('TRUNCATE TABLE materias CASCADE');
        DB::statement('TRUNCATE TABLE estudiantes CASCADE');
        DB::statement('TRUNCATE TABLE users CASCADE');

        echo "✅ Base de datos limpia\n\n";

        // 1. Crear usuario de prueba
        echo "👤 Creando usuario de prueba...\n";
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        echo "✅ Usuario creado\n\n";

        // 2. Crear 6 asignaturas
        echo "📚 Creando 6 asignaturas...\n";
        $materias = [
            [
                'nombre' => 'Cálculo I',
                'codigo' => 'MAT-101',
                'creditos' => 4,
                'descripcion' => 'Fundamentos de cálculo diferencial',
                'profesor' => 'Dr. Juan García',
                'horas_semana' => 4,
            ],
            [
                'nombre' => 'Álgebra Lineal',
                'codigo' => 'MAT-102',
                'creditos' => 3,
                'descripcion' => 'Matrices, vectores y transformaciones lineales',
                'profesor' => 'Dra. María López',
                'horas_semana' => 3,
            ],
            [
                'nombre' => 'Física I',
                'codigo' => 'FIS-101',
                'creditos' => 4,
                'descripcion' => 'Mecánica clásica y cinemática',
                'profesor' => 'Dr. Carlos Rodríguez',
                'horas_semana' => 4,
            ],
            [
                'nombre' => 'Programación I',
                'codigo' => 'INF-101',
                'creditos' => 4,
                'descripcion' => 'Introducción a la programación en Python',
                'profesor' => 'Ing. Ana Martínez',
                'horas_semana' => 4,
            ],
            [
                'nombre' => 'Química General',
                'codigo' => 'QUI-101',
                'creditos' => 3,
                'descripcion' => 'Principios de química orgánica e inorgánica',
                'profesor' => 'Dr. Pedro Sánchez',
                'horas_semana' => 3,
            ],
            [
                'nombre' => 'Historia Universal',
                'codigo' => 'HIS-101',
                'creditos' => 2,
                'descripcion' => 'Siglos XIX y XX en perspectiva global',
                'profesor' => 'Dra. Teresa González',
                'horas_semana' => 2,
            ],
        ];

        $materiaIds = [];
        foreach ($materias as $materia) {
            $m = Materia::create($materia);
            $materiaIds[] = $m->id;
            echo "  ✓ {$materia['nombre']} ({$materia['codigo']})\n";
        }
        echo "✅ 6 asignaturas creadas\n\n";

        // 3. Crear 100 estudiantes
        echo "👨‍🎓 Creando 100 estudiantes...\n";
        $estudiantes = Estudiante::factory(100)->create();
        echo "✅ 100 estudiantes creados\n\n";

        // 4. Crear inscripciones y calificaciones
        echo "📝 Creando inscripciones y calificaciones...\n";
        
        $totalInscripciones = 0;
        $totalCalificaciones = 0;

        foreach ($estudiantes as $estudiante) {
            // Cada estudiante se inscribe en 3-6 materias
            $numeromaterias = rand(3, 6);
            $materiasAsignadas = collect($materiaIds)->random($numeromaterias)->toArray();

            foreach ($materiasAsignadas as $materiaId) {
                // Crear inscripción
                $inscripcion = Inscripcion::create([
                    'estudiante_id' => $estudiante->id,
                    'materia_id' => $materiaId,
                    'fecha_inscripcion' => now()->subDays(rand(30, 180)),
                    'estado' => 'activa',
                    'promedio' => 0, // Se calculará con las calificaciones
                ]);
                $totalInscripciones++;

                // Crear 3-5 calificaciones para esta inscripción
                $numeroCalificaciones = rand(3, 5);
                $tipos = ['Parcial 1', 'Parcial 2', 'Parcial 3', 'Final', 'Trabajo Práctico'];
                $tiposAsignados = collect($tipos)->random($numeroCalificaciones)->toArray();

                $notas = [];
                foreach ($tiposAsignados as $tipo) {
                    $nota = rand(0, 500) / 100; // De 0.00 a 5.00
                    Calificacion::create([
                        'inscripcion_id' => $inscripcion->id,
                        'nota' => $nota,
                        'tipo' => $tipo,
                        'fecha' => now()->subDays(rand(1, 90)),
                        'observaciones' => null,
                    ]);
                    $notas[] = $nota;
                    $totalCalificaciones++;
                }

                // Actualizar promedio de la inscripción
                $promedio = round(array_sum($notas) / count($notas), 2);
                $inscripcion->update(['promedio' => $promedio]);
            }

            // Mostrar progreso cada 10 estudiantes
            if ($estudiante->id % 10 === 0) {
                echo "  ✓ {$estudiante->id}/100 estudiantes procesados\n";
            }
        }

        echo "✅ Inscripciones creadas: $totalInscripciones\n";
        echo "✅ Calificaciones creadas: $totalCalificaciones\n\n";

        echo "╔════════════════════════════════════════╗\n";
        echo "║  ✨ DATASET CREADO EXITOSAMENTE ✨   ║\n";
        echo "╠════════════════════════════════════════╣\n";
        echo "║ Estudiantes:     100                  ║\n";
        echo "║ Asignaturas:     6                    ║\n";
        echo "║ Inscripciones:   $totalInscripciones                 ║\n";
        echo "║ Calificaciones:  $totalCalificaciones                ║\n";
        echo "╚════════════════════════════════════════╝\n\n";
    }
}
