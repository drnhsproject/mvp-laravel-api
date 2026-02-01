<?php

namespace App\Modules\Privilege\Application\UseCases;

use App\Models\Privilege;

class GetPrivilege
{
    public function execute(int $id): ?Privilege
    {
        return Privilege::find($id);
    }
}
