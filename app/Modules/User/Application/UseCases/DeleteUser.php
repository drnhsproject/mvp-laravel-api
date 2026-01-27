<?php

namespace App\Modules\User\Application\UseCases;

use App\Modules\User\Domain\Contracts\UserRepositoryInterface;

class DeleteUser
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}
