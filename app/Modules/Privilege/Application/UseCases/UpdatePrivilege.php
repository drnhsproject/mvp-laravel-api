<?php

namespace App\Modules\Privilege\Application\UseCases;

use App\Models\Privilege;

class UpdatePrivilege
{
    public function execute(int $id, array $data): bool
    {
        $privilege = Privilege::find($id);
        if (!$privilege) return false;

        return $privilege->update($data);
    }
}
