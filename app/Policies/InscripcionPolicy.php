<?php

namespace App\Policies;

use App\Models\Inscripcion;
use App\Models\User;

class InscripcionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Inscripcion $inscripcion): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Inscripcion $inscripcion): bool
    {
        return true;
    }

    public function delete(User $user, Inscripcion $inscripcion): bool
    {
        return true;
    }

    public function restore(User $user, Inscripcion $inscripcion): bool
    {
        return false;
    }

    public function forceDelete(User $user, Inscripcion $inscripcion): bool
    {
        return false;
    }
}
