<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    public function list(User $user): bool
    {
        return $user->hasPrivilege('role', 'list', 'role.list');
    }

    public function detail(User $user, Role $role): bool
    {
        return $user->hasPrivilege('role', 'detail', 'role.detail');
    }

    public function create(User $user): bool
    {
        return $user->hasPrivilege('role', 'create', 'role.create');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPrivilege('role', 'update', 'role.update');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPrivilege('role', 'delete', 'role.delete');
    }
}
