<?php

namespace App\Modules\Privilege\Application\UseCases;

use App\Models\Privilege;
use App\Modules\Privilege\Application\DTOs\GetPrivilegeListQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetPrivilegeList
{
    public function execute(GetPrivilegeListQuery $query): LengthAwarePaginator
    {
        return Privilege::query()
            ->when($query->search, function ($q) use ($query) {
                // Search in module, action, or namespace
                $s = "%{$query->search}%";
                $q->where('module', 'like', $s)
                    ->orWhere('action', 'like', $s)
                    ->orWhere('namespace', 'like', $s);
            })
            ->orderBy($query->sort, $query->order)
            ->paginate($query->perPage);
    }
}
