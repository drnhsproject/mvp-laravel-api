<?php

namespace App\Modules\Privilege\Application\DTOs;

class GetPrivilegeListQuery
{
    public function __construct(
        public ?string $search = null,
        public int $page = 1,
        public int $perPage = 10,
        public string $sort = 'created_at',
        public string $order = 'desc'
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            $request['search'] ?? null,
            (int) ($request['page'] ?? 1),
            (int) ($request['per_page'] ?? 10),
            $request['sort'] ?? 'created_at',
            $request['order'] ?? 'desc'
        );
    }
}
