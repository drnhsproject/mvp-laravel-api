<?php

namespace App\Modules\SysParams\Application\UseCases;

use App\Modules\SysParams\Domain\Contracts\SystemParameterRepositoryInterface;

class DeleteSystemParameter
{
    public function __construct(
        private readonly SystemParameterRepositoryInterface $repository
    ) {}

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
