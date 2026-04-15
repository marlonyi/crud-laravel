<?php

namespace App\Providers;

use App\Events\InscripcionCreada;
use App\Listeners\EnviarEmailConfirmacion;
use App\Listeners\NotificarAlProfesor;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(
            InscripcionCreada::class,
            [
                EnviarEmailConfirmacion::class,
                NotificarAlProfesor::class,
            ]
        );
    }
}
