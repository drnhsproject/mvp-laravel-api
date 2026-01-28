<?php

namespace Database\Seeders;

use App\Models\Privilege;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'user' => [
                'actions' => ['list', 'detail', 'create', 'edit', 'update', 'delete'],
                'uri_prefix' => '/users'
            ],
            'role' => [
                'actions' => ['list', 'detail', 'create', 'edit', 'update', 'delete'],
                'uri_prefix' => '/roles'
            ],
            'privilege' => [
                'actions' => ['list', 'detail', 'create', 'edit', 'update', 'delete'],
                'uri_prefix' => '/privileges'
            ],
        ];

        $actionMethods = [
            'list' => 'GET',
            'detail' => 'GET',
            'create' => 'POST', // API Create
            'edit' => 'GET', // FE Form
            'update' => 'PUT,PATCH',
            'delete' => 'DELETE',
        ];

        foreach ($modules as $module => $config) {
            foreach ($config['actions'] as $action) {
                // Determine HTTP Method
                $method = $actionMethods[$action] ?? '*';

                // Determine URI
                $uri = $config['uri_prefix'];
                if ($action === 'create') $uri .= '/create';
                if ($action === 'detail') $uri .= '/:id';
                if ($action === 'edit') $uri .= '/:id/edit';
                if ($action === 'update') $uri .= '/:id';
                if ($action === 'delete') $uri .= '/:id';

                Privilege::updateOrCreate(
                    [
                        'module' => $module,
                        'action' => $action,
                    ],
                    [
                        'code' => (string) Str::uuid(),
                        'submodule' => $module,
                        'method' => $method,
                        'uri' => $uri,
                        // Namespace is used as the Permission Slug / Route Name (e.g., "user.list")
                        'namespace' => "{$module}.{$action}",
                    ]
                );
            }
        }
    }
}
