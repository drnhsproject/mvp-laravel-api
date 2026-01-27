<?php

namespace App\Modules\User\Domain\Contracts;

use App\Models\User;
use App\Modules\User\Application\Commands\CreateUserCommand;
use App\Modules\User\Application\DTOs\GetUserListQuery;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function paginate(GetUserListQuery $query): LengthAwarePaginator;
    public function findById(int $id): ?User;
    public function findByCode(string $code): ?User;
    public function create(CreateUserCommand $command): User;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
