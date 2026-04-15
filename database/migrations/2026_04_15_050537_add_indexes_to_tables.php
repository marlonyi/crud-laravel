<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->index('created_at', 'idx_estudiantes_created_at');
            $table->index(['nombre', 'apellido'], 'idx_estudiantes_nombre_apellido');
        });

        Schema::table('materias', function (Blueprint $table) {
            $table->index('created_at', 'idx_materias_created_at');
            $table->index('profesor', 'idx_materias_profesor');
        });

        Schema::table('inscripcions', function (Blueprint $table) {
            $table->index('estado', 'idx_inscripcions_estado');
            $table->index('fecha_inscripcion', 'idx_inscripcions_fecha');
            $table->index('estudiante_id', 'idx_inscripcions_estudiante');
            $table->index('materia_id', 'idx_inscripcions_materia');
        });

        Schema::table('calificacions', function (Blueprint $table) {
            $table->index('fecha', 'idx_calificacions_fecha');
            $table->index('inscripcion_id', 'idx_calificacions_inscripcion');
            $table->index(['inscripcion_id', 'tipo'], 'idx_calificacions_inscripcion_tipo');
        });
    }

    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropIndex('idx_estudiantes_created_at');
            $table->dropIndex('idx_estudiantes_nombre_apellido');
        });

        Schema::table('materias', function (Blueprint $table) {
            $table->dropIndex('idx_materias_created_at');
            $table->dropIndex('idx_materias_profesor');
        });

        Schema::table('inscripcions', function (Blueprint $table) {
            $table->dropIndex('idx_inscripcions_estado');
            $table->dropIndex('idx_inscripcions_fecha');
            $table->dropIndex('idx_inscripcions_estudiante');
            $table->dropIndex('idx_inscripcions_materia');
        });

        Schema::table('calificacions', function (Blueprint $table) {
            $table->dropIndex('idx_calificacions_fecha');
            $table->dropIndex('idx_calificacions_inscripcion');
            $table->dropIndex('idx_calificacions_inscripcion_tipo');
        });
    }
};
