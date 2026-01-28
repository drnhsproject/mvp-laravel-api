<?php

namespace App\Modules\Role\Application\UseCases;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class DeleteRole
{
    public function execute(int $id): bool
    {
        $role = Role::find($id);

        if (!$role) {
            return false;
        }

        // Check if role is assigned to users?
        // Usually safer to block delete if users exist.
        if ($role->users()->exists()) {
            // throw new \Exception('cannot delete role assigned to users');
            // For simple MVP boolean return, we might fail or let generic handling.
            // But let's assume standard behavior: detach or block.
            // Usually block.
            return false;
        }

        return DB::transaction(function () use ($role) {
            $role->privileges()->detach();
            return $role->delete();
        });
    }
}
