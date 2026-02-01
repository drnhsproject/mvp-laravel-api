<?php

namespace App\Modules\SysParams\Application\DTOs;

readonly class GetSystemParameterListQuery
{
    public function __construct(
        public ?string $search = null,
        public ?string $groups = null,
        public int $page = 1,
        public int $perPage = 10,
        public string $sortBy = 'ordering',
        public string $sortOrder = 'asc',
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            search: $request['search'] ?? null,
            groups: $request['groups'] ?? null,
            page: (int) ($request['page'] ?? 1),
            perPage: (int) ($request['per_page'] ?? 10),
            sortBy: $request['sort_by'] ?? 'ordering',
            sortOrder: $request['sort_order'] ?? 'asc',
        );
    }
}
