<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Privilege;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ViewerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Viewer Role
        $role = Role::updateOrCreate(
            ['name' => 'ROLE_VIEWER'],
            ['is_active' => true]
        );

        // 2. Find "view" privileges for users, roles, privileges
        // Updated modules are singular: user, role, privilege
        // Updated actions: list, detail
        $modules = ['user', 'role', 'privilege'];

        $privileges = Privilege::whereIn('module', $modules)
            ->whereIn('action', ['list', 'detail'])
            ->get();

        // 3. Assign privileges to Role
        // syncWithoutDetaching enables re-running seeder safely (though sync is also fine if we define full state)
        // sync(...) replaces all. Since this is a specific definition for Viewer, sync is safer to Ensure exact state.
        $role->privileges()->sync($privileges->pluck('id'));

        // 4. Create a Viewer User
        $user = User::updateOrCreate(
            ['email' => 'viewer@app.com'],
            [
                'full_name' => 'User Viewer',
                'username' => 'viewer',
                'password' => Hash::make('Viewer@123'),
                'is_active' => true,
                'is_verified' => true,
            ]
        );

        // Assign Role
        $user->roles()->syncWithoutDetaching([$role->id]);
    }
}
