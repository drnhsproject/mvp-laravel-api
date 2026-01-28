<?php

namespace App\Modules\Role\Application\UseCases;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdateRole
{
    public function execute(int $id, array $data): bool
    {
        $role = Role::find($id);

        if (!$role) {
            return false;
        }

        return DB::transaction(function () use ($role, $data) {
            $updated = $role->update([
                'name' => $data['name'] ?? $role->name,
                'description' => $data['description'] ?? $role->description,
                'is_active' => $data['is_active'] ?? $role->is_active,
            ]);

            if (isset($data['privileges'])) {
                $role->privileges()->sync($data['privileges']);
            }

            return $updated;
        });
    }
}
