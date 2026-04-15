<?php

namespace App\Policies;

use App\Models\Estudiante;
use App\Models\User;

class EstudiantePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Estudiante $estudiante): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Estudiante $estudiante): bool
    {
        return true;
    }

    public function delete(User $user, Estudiante $estudiante): bool
    {
        return true;
    }

    public function restore(User $user, Estudiante $estudiante): bool
    {
        return false;
    }

    public function forceDelete(User $user, Estudiante $estudiante): bool
    {
        return false;
    }
}
