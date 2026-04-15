<?php

namespace App\Policies;

use App\Models\Materia;
use App\Models\User;

class MateriaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Materia $materia): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Materia $materia): bool
    {
        return true;
    }

    public function delete(User $user, Materia $materia): bool
    {
        return true;
    }

    public function restore(User $user, Materia $materia): bool
    {
        return false;
    }

    public function forceDelete(User $user, Materia $materia): bool
    {
        return false;
    }
}
