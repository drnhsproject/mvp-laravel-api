<?php

namespace App\Policies;

use App\Models\Privilege;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrivilegePolicy
{
    public function list(User $user): bool
    {
        return $user->hasPrivilege('privilege', 'list', 'privilege.list');
    }

    public function detail(User $user, Privilege $privilege): bool
    {
        return $user->hasPrivilege('privilege', 'detail', 'privilege.detail');
    }

    public function create(User $user): bool
    {
        return $user->hasPrivilege('privilege', 'create', 'privilege.create');
    }

    public function update(User $user, Privilege $privilege): bool
    {
        return $user->hasPrivilege('privilege', 'update', 'privilege.update');
    }

    public function delete(User $user, Privilege $privilege): bool
    {
        return $user->hasPrivilege('privilege', 'delete', 'privilege.delete');
    }
}
