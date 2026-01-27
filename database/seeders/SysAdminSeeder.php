<?php

namespace Database\Seeders;

use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SysAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create or Update Super Admin Role
        $role = Role::updateOrCreate(
            ['name' => 'Super Admin'],
            ['is_active' => true]
        );

        // 2. Create All Access Privilege if not exists
        $privilege = Privilege::updateOrCreate(
            ['module' => 'All Access', 'action' => 'All Access'],
            ['submodule' => 'All Access', 'method' => '*', 'uri' => '*', 'namespace' => '*', 'ordering' => 0]
        );

        // 3. Sync Privileges
        $role->privileges()->syncWithoutDetaching([$privilege->id]);

        // 4. Create Users
        $users = [
            [
                'full_name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@app.com',
                'password' => Hash::make('Admin@321'),
            ],
            [
                'full_name' => 'System',
                'username' => 'system',
                'email' => 'system@app.com',
                'password' => Hash::make('Admin@321'),
            ]
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'full_name' => $userData['full_name'],
                    'username' => $userData['username'],
                    'password' => $userData['password'],
                    'is_active' => true,
                    'is_verified' => true,
                ]
            );

            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
