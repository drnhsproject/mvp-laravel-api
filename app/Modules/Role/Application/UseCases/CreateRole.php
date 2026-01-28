<?php

namespace App\Modules\Role\Application\UseCases;

use App\Models\Role;
use App\Modules\Role\Application\Commands\CreateRoleCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateRole
{
    public function execute(CreateRoleCommand $command): Role
    {
        return DB::transaction(function () use ($command) {
            $role = Role::create([
                'name' => $command->name,
                'code' => (string) Str::uuid(),
                'description' => $command->description,
                'is_active' => true,
            ]);

            if (!empty($command->privileges)) {
                $role->privileges()->sync($command->privileges);
            }

            return $role->load('privileges');
        });
    }
}
