<?php

namespace App\Modules\SysParams\Application\UseCases;

use App\Modules\SysParams\Application\Commands\CreateSystemParameterCommand;
use App\Modules\SysParams\Domain\Contracts\SystemParameterRepositoryInterface;

class CreateSystemParameter
{
    public function __construct(
        private readonly SystemParameterRepositoryInterface $repository
    ) {}

    public function execute(CreateSystemParameterCommand $command): object
    {
        return $this->repository->create($command);
    }
}
