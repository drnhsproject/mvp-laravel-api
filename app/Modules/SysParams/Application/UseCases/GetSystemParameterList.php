<?php

namespace App\Modules\SysParams\Application\UseCases;

use App\Modules\SysParams\Application\DTOs\GetSystemParameterListQuery;
use App\Modules\SysParams\Domain\Contracts\SystemParameterRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetSystemParameterList
{
    public function __construct(
        private readonly SystemParameterRepositoryInterface $repository
    ) {}

    public function execute(GetSystemParameterListQuery $query): LengthAwarePaginator
    {
        return $this->repository->paginate($query);
    }
}
