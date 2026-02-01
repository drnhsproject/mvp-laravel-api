<?php

namespace App\Modules\SysParams\Domain\Contracts;

use App\Modules\SysParams\Application\Commands\CreateSystemParameterCommand;
use App\Modules\SysParams\Application\Commands\UpdateSystemParameterCommand;
use App\Modules\SysParams\Application\DTOs\GetSystemParameterListQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SystemParameterRepositoryInterface
{
    /**
     * Get paginated list of system parameters with filtering and sorting.
     */
    public function paginate(GetSystemParameterListQuery $query): LengthAwarePaginator;

    /**
     * Find a system parameter by ID.
     */
    public function findById(int $id): ?object;

    /**
     * Find a system parameter by code.
     */
    public function findByCode(string $code): ?object;

    /**
     * Create a new system parameter.
     */
    public function create(CreateSystemParameterCommand $command): object;

    /**
     * Update an existing system parameter.
     */
    public function update(int $id, UpdateSystemParameterCommand $command): object;

    /**
     * Delete a system parameter (soft delete).
     */
    public function delete(int $id): bool;
}
