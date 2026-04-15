<?php

namespace App\Events;

use App\Models\Inscripcion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InscripcionCreada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Inscripcion $inscripcion
    ) {}
}
