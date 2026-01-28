<?php

namespace App\Modules\Role\Application\UseCases;

use App\Models\Role;

class GetRole
{
    public function execute(int $id): ?Role
    {
        return Role::with('privileges')->find($id);
    }
}
