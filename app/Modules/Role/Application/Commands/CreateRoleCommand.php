<?php

namespace App\Modules\Role\Application\Commands;

class CreateRoleCommand
{
    public function __construct(
        public string $name,
        public ?string $description,
        public array $privileges = []
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['name'],
            $data['description'] ?? null,
            $data['privileges'] ?? []
        );
    }
}
