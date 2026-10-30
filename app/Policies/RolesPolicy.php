<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roles;
class RolesPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->roles?->role === 'admin' ? true : false;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Roles $roles): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Roles $roles): bool
    {
        return false;
    }

    public function delete(User $user, Roles $roles): bool
    {
        return false;
    }
}
