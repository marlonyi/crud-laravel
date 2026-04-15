<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Enums\InscripcionEstado;
use App\Enums\CalificacionTipo;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 5 materias adicionales
        $materiasData = [
            ['nombre' => 'Matemáticas Avanzadas', 'codigo' => 'MAT-201', 'creditos' => 4, 'profesor' => 'Dr. Carlos Ruiz', 'horas_semana' => 6, 'descripcion' => 'Cálculo diferencial e integral'],
            ['nombre' => 'Física General', 'codigo' => 'FIS-101', 'creditos' => 4, 'profesor' => 'Dra. Ana Torres', 'horas_semana' => 6, 'descripcion' => 'Mecánica y termodinámica'],
            ['nombre' => 'Programación Orientada a Objetos', 'codigo' => 'INF-150', 'creditos' => 3, 'profesor' => 'Ing. Luis Mendoza', 'horas_semana' => 4, 'descripcion' => 'Fundamentos de POO con Java'],
            ['nombre' => 'Base de Datos', 'codigo' => 'INF-200', 'creditos' => 4, 'profesor' => 'MSc. Roberto Díaz', 'horas_semana' => 5, 'descripcion' => 'Diseño y administración de BD'],
            ['nombre' => 'Inglés Técnico', 'codigo' => 'IDI-101', 'creditos' => 2, 'profesor' => 'Lic. María González', 'horas_semana' => 3, 'descripcion' => 'Inglés para informática'],
        ];

        foreach ($materiasData as $materiaData) {
            Materia::create($materiaData);
        }

        // Obtener todas las materias
        $materias = Materia::all();

        // Crear 10 estudiantes
        $estudiantesData = [
            ['nombre' => 'Juan', 'apellido' => 'Pérez', 'email' => 'juan.perez@estudiante.com', 'cedula' => '800-1234-567', 'telefono' => '8001-1111', 'fecha_nacimiento' => '2000-01-15'],
            ['nombre' => 'María', 'apellido' => 'García', 'email' => 'maria.garcia@estudiante.com', 'cedula' => '800-2345-678', 'telefono' => '8001-2222', 'fecha_nacimiento' => '2000-02-20'],
            ['nombre' => 'Carlos', 'apellido' => 'Rodríguez', 'email' => 'carlos.rodriguez@estudiante.com', 'cedula' => '800-3456-789', 'telefono' => '8001-3333', 'fecha_nacimiento' => '2000-03-10'],
            ['nombre' => 'Ana', 'apellido' => 'Martínez', 'email' => 'ana.martinez@estudiante.com', 'cedula' => '800-4567-890', 'telefono' => '8001-4444', 'fecha_nacimiento' => '2000-04-05'],
            ['nombre' => 'Luis', 'apellido' => 'Hernández', 'email' => 'luis.hernandez@estudiante.com', 'cedula' => '800-5678-901', 'telefono' => '8001-5555', 'fecha_nacimiento' => '2000-05-12'],
            ['nombre' => 'Sofía', 'apellido' => 'López', 'email' => 'sofia.lopez@estudiante.com', 'cedula' => '800-6789-012', 'telefono' => '8001-6666', 'fecha_nacimiento' => '2000-06-18'],
            ['nombre' => 'Pedro', 'apellido' => 'Sánchez', 'email' => 'pedro.sanchez@estudiante.com', 'cedula' => '800-7890-123', 'telefono' => '8001-7777', 'fecha_nacimiento' => '2000-07-22'],
            ['nombre' => 'Laura', 'apellido' => 'Ramírez', 'email' => 'laura.ramirez@estudiante.com', 'cedula' => '800-8901-234', 'telefono' => '8001-8888', 'fecha_nacimiento' => '2000-08-30'],
            ['nombre' => 'Diego', 'apellido' => 'Torres', 'email' => 'diego.torres@estudiante.com', 'cedula' => '800-9012-345', 'telefono' => '8001-9999', 'fecha_nacimiento' => '2000-09-14'],
            ['nombre' => 'Carmen', 'apellido' => 'Flores', 'email' => 'carmen.flores@estudiante.com', 'cedula' => '800-0123-456', 'telefono' => '8001-0000', 'fecha_nacimiento' => '2000-10-25'],
        ];

        foreach ($estudiantesData as $estudianteData) {
            $estudiante = Estudiante::create($estudianteData);

            // Asignar 3 materias aleatorias a cada estudiante
            $materiasAsignadas = $materias->random(3);

            foreach ($materiasAsignadas as $materia) {
                $inscripcion = Inscripcion::create([
                    'estudiante_id' => $estudiante->id,
                    'materia_id' => $materia->id,
                    'estado' => InscripcionEstado::ACTIVA,
                    'fecha_inscripcion' => now(),
                ]);

                // Crear 3-5 calificaciones por inscripción
                $numCalificaciones = rand(3, 5);
                $tiposDisponibles = CalificacionTipo::cases();

                for ($i = 0; $i < $numCalificaciones; $i++) {
                    $tipo = $tiposDisponibles[array_rand($tiposDisponibles)];

                    Calificacion::create([
                        'inscripcion_id' => $inscripcion->id,
                        'nota' => round(rand(30, 50) / 10, 2), // Notas entre 3.0 y 5.0
                        'tipo' => $tipo,
                        'fecha' => now()->subDays(rand(1, 30)),
                        'observaciones' => $this->getObservacionAleatoria(),
                    ]);
                }
            }
        }

        $this->command->info('✅ Datos de prueba creados exitosamente!');
        $this->command->info('   - 5 materias adicionales');
        $this->command->info('   - 10 estudiantes');
        $this->command->info('   - 30 inscripciones (3 por estudiante)');
        $this->command->info('   - ~120 calificaciones');
    }

    private function getObservacionAleatoria(): ?string
    {
        $observaciones = [
            null,
            'Excelente participación en clase',
            'Debe mejorar la entrega de tareas',
            'Buen desempeño en exámenes',
            'Se recomienda reforzar temas prácticos',
            'Estudiante destacado',
            'Necesita más dedicación',
        ];

        return $observaciones[array_rand($observaciones)];
    }
}
