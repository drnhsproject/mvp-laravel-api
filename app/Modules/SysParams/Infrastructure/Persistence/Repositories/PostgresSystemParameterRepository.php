<?php

namespace App\Modules\SysParams\Infrastructure\Persistence\Repositories;

use App\Models\SystemParameter;
use App\Modules\SysParams\Application\Commands\CreateSystemParameterCommand;
use App\Modules\SysParams\Application\Commands\UpdateSystemParameterCommand;
use App\Modules\SysParams\Application\DTOs\GetSystemParameterListQuery;
use App\Modules\SysParams\Domain\Contracts\SystemParameterRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostgresSystemParameterRepository implements SystemParameterRepositoryInterface
{
    public function paginate(GetSystemParameterListQuery $query): LengthAwarePaginator
    {
        $eloquentQuery = SystemParameter::query();

        // Filter by groups if provided
        if ($query->groups) {
            $eloquentQuery->where('groups', $query->groups);
        }

        // Search across key, value, and description
        if ($query->search) {
            $searchTerm = "%{$query->search}%";
            $eloquentQuery->where(function ($q) use ($searchTerm) {
                $q->where('key', 'ilike', $searchTerm)
                    ->orWhere('value', 'ilike', $searchTerm)
                    ->orWhere('description', 'ilike', $searchTerm);
            });
        }

        return $eloquentQuery
            ->orderBy($query->sortBy, $query->sortOrder)
            ->paginate($query->perPage, ['*'], 'page', $query->page);
    }

    public function findById(int $id): ?SystemParameter
    {
        return SystemParameter::find($id);
    }

    public function findByCode(string $code): ?SystemParameter
    {
        return SystemParameter::where('code', $code)->first();
    }

    public function create(CreateSystemParameterCommand $command): SystemParameter
    {
        return SystemParameter::create($command->toArray());
    }

    public function update(int $id, UpdateSystemParameterCommand $command): SystemParameter
    {
        $systemParameter = $this->findById($id);

        if (!$systemParameter) {
            throw new \Exception("System parameter not found with ID: {$id}");
        }

        $systemParameter->update($command->toArray());

        return $systemParameter->fresh();
    }

    public function delete(int $id): bool
    {
        $systemParameter = SystemParameter::find($id);

        if (!$systemParameter) {
            return false;
        }

        $systemParameter->update(['status' => 0]);

        return $systemParameter->delete();
    }
}
