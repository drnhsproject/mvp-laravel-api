<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function list(User $user): bool
    {
        return $user->hasPrivilege('user', 'list', 'user.list');
    }

    public function detail(User $user, User $model): bool
    {
        return $user->hasPrivilege('user', 'detail', 'user.detail') || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->hasPrivilege('user', 'create', 'user.create');
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPrivilege('user', 'update', 'user.update');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPrivilege('user', 'delete', 'user.delete');
    }

    public function restore(User $user, User $model): bool
    {
        return $user->hasPrivilege('user', 'delete', 'user.delete');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasPrivilege('user', 'delete', 'user.delete');
    }
}
