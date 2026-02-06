<?php

namespace App\Modules\SysParams\Application\UseCases;

use App\Modules\SysParams\Domain\Contracts\SystemParameterRepositoryInterface;
use Illuminate\Support\Collection;

class GetSystemParameterOptions
{
    public function __construct(
        protected SystemParameterRepositoryInterface $repository
    ) {}

    public function execute(string $group): Collection
    {
        return $this->repository->getOptionsByGroup($group);
    }
}
