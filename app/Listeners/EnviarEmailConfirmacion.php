<?php

namespace App\Listeners;

use App\Events\InscripcionCreada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarEmailConfirmacion implements ShouldQueue
{
    public function __construct() {}

    public function handle(InscripcionCreada $event): void
    {
        $inscripcion = $event->inscripcion;

        Log::info('Email de confirmación enviado para inscripción #' . $inscripcion->id);
        
        // Aquí iría el envío real de email:
        // Mail::to($inscripcion->estudiante->email)->send(new InscripcionConfirmada($inscripcion));
    }
}
