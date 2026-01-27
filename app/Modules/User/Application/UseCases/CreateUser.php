<?php

namespace App\Modules\User\Application\UseCases;

use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Models\User;
use App\Modules\User\Application\Commands\CreateUserCommand;

class CreateUser
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(CreateUserCommand $command): User
    {
        return $this->userRepository->create($command);
    }
}
