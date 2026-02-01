<?php

namespace App\Modules\Privilege\Application\UseCases;

use App\Models\Privilege;
use Illuminate\Support\Str;

class CreatePrivilege
{
    public function execute(array $data): Privilege
    {
        return Privilege::create([
            'code' => (string) Str::uuid(),
            'module' => $data['module'],
            'submodule' => $data['submodule'] ?? $data['module'],
            'action' => $data['action'],
            'method' => $data['method'] ?? '*',
            'uri' => $data['uri'] ?? '',
            'namespace' => $data['namespace'] ?? '*',
        ]);
    }
}
