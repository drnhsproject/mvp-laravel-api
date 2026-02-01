<?php

namespace App\Modules\Privilege\Application\UseCases;

use App\Models\Privilege;

class DeletePrivilege
{
    public function execute(int $id): bool
    {
        $privilege = Privilege::find($id);
        if (!$privilege) return false;

        // Constraint check: privileges used by roles?
        // Usually privileges are synced. If deleted, should be removed from role_privilege.
        // Laravel cascade on delete usually handles this if defined.
        // Assuming cascade or detach.
        // Let's detach safely manually or rely on foreign keys.
        // I will detach first for safety.
        $privilege->roles()->detach();

        return $privilege->delete();
    }
}
