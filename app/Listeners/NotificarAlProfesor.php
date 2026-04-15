<?php

namespace App\Listeners;

use App\Events\InscripcionCreada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotificarAlProfesor implements ShouldQueue
{
    public function __construct() {}

    public function handle(InscripcionCreada $event): void
    {
        $inscripcion = $event->inscripcion;
        
        Log::info('Profesor notificado: ' . $inscripcion->materia->profesor . 
                  ' - Nuevo estudiante: ' . $inscripcion->estudiante->nombre_completo);
        
        // Aquí iría la notificación real al profesor
    }
}
