<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar constraint CHECK para nota entre 0 y 5
        DB::statement('ALTER TABLE calificacions ADD CONSTRAINT chk_nota_range CHECK (nota >= 0 AND nota <= 5)');

        // Agregar constraint CHECK para observaciones (max 1000 caracteres)
        // Primero cambiamos el tipo de columna a TEXT
        Schema::table('calificacions', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE calificacions DROP CONSTRAINT IF EXISTS chk_nota_range');

        Schema::table('calificacions', function (Blueprint $table) {
            $table->string('observaciones')->nullable()->change();
        });
    }
};
