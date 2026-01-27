<?php

namespace App\Modules\User\Application\UseCases;

use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\User\Application\DTOs\GetUserListQuery;

class GetUserList
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(GetUserListQuery $query): LengthAwarePaginator
    {
        return $this->userRepository->paginate($query);
    }
}
