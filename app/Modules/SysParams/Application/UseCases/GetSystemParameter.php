<?php

namespace App\Modules\SysParams\Application\UseCases;

use App\Modules\SysParams\Domain\Contracts\SystemParameterRepositoryInterface;

class GetSystemParameter
{
    public function __construct(
        private readonly SystemParameterRepositoryInterface $repository
    ) {}

    public function execute(int $id): ?object
    {
        return $this->repository->findById($id);
    }
}
