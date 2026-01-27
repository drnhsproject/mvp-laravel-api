<?php

namespace App\Modules\User\Application\UseCases;

use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Models\User;

class GetUser
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
