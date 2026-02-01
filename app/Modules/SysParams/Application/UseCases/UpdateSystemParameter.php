<?php

namespace App\Modules\SysParams\Application\UseCases;

use App\Modules\SysParams\Application\Commands\UpdateSystemParameterCommand;
use App\Modules\SysParams\Domain\Contracts\SystemParameterRepositoryInterface;

class UpdateSystemParameter
{
    public function __construct(
        private readonly SystemParameterRepositoryInterface $repository
    ) {}

    public function execute(int $id, UpdateSystemParameterCommand $command): object
    {
        return $this->repository->update($id, $command);
    }
}
