<?php

namespace App\Modules\User\Application\DTOs;

readonly class GetUserListQuery
{
    public function __construct(
        public ?string $search = null,
        public int $page = 1,
        public int $perPage = 10,
        public string $sortColumn = 'created_at',
        public string $sortDirection = 'desc'
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            search: $request['search'] ?? null,
            page: (int) ($request['page'] ?? 1),
            perPage: (int) ($request['size'] ?? 10), // User asked for 'size' in query param
            sortColumn: $request['sort'] ?? 'created_at',
            sortDirection: $request['dir'] ?? 'desc'
        );
    }
}
