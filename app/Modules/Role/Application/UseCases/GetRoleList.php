<?php

namespace App\Modules\Role\Application\UseCases;

use App\Models\Role;
use App\Modules\Role\Application\DTOs\GetRoleListQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetRoleList
{
    public function execute(GetRoleListQuery $query): LengthAwarePaginator
    {
        return Role::query()
            ->when($query->search, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query->search}%")
                    ->orWhere('description', 'like', "%{$query->search}%");
            })
            ->orderBy($query->sort, $query->order)
            ->paginate($query->perPage);
    }
}
