<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPrivilege('users', 'view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Admin can view any, or User can view themselves?
        return $user->hasPrivilege('users', 'view') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPrivilege('users', 'create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Admin can update any, or User can update themselves?
        // Usually /api/users/{id} is strictly Admin management.
        // Self-update is usually /api/me/profile.
        // If we allow self-update here:
        // return $user->hasPrivilege('users', 'update') || $user->id === $model->id;
        // BUT user asked "jangan sampai user a bisa merubah user b".
        // This usually implies Admin/Privilege check.
        return $user->hasPrivilege('users', 'update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasPrivilege('users', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasPrivilege('users', 'delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasPrivilege('users', 'delete');
    }
}
