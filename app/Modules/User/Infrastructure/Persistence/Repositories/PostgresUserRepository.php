<?php

namespace App\Modules\User\Infrastructure\Persistence\Repositories;

use App\Models\User;
use App\Modules\User\Application\Commands\CreateUserCommand;
use App\Modules\User\Application\DTOs\GetUserListQuery;
use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class PostgresUserRepository implements UserRepositoryInterface
{
    public function paginate(GetUserListQuery $query): LengthAwarePaginator
    {
        $eloquentQuery = User::query();

        if ($query->search) {
            $searchTerm = "%{$query->search}%";
            $eloquentQuery->where(function ($q) use ($searchTerm) {
                $q->where('full_name', 'ilike', $searchTerm)
                    ->orWhere('email', 'ilike', $searchTerm)
                    ->orWhere('username', 'ilike', $searchTerm);
            });
        }

        return $eloquentQuery->with('roles')
            ->orderBy($query->sortColumn, $query->sortDirection)
            ->paginate($query->perPage, ['*'], 'page', $query->page);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByCode(string $code): ?User
    {
        return User::where('code', $code)->first();
    }

    public function create(CreateUserCommand $command): User
    {
        $userData = $command->toArray();
        if (isset($userData['password'])) {
            $userData['password'] = Hash::make($userData['password']);
        }
        return User::create($userData);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->findById($id);
        if (!$user) {
            return false;
        }

        if (isset($data['password'])) {
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }
        }

        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        return User::destroy($id) > 0;
    }
}
