<?php

namespace App\Policies;

use App\Models\Calificacion;
use App\Models\User;

class CalificacionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Calificacion $calificacion): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Calificacion $calificacion): bool
    {
        return true;
    }

    public function delete(User $user, Calificacion $calificacion): bool
    {
        return true;
    }

    public function restore(User $user, Calificacion $calificacion): bool
    {
        return false;
    }

    public function forceDelete(User $user, Calificacion $calificacion): bool
    {
        return false;
    }
}
