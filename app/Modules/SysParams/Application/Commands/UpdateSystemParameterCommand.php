<?php

namespace App\Modules\SysParams\Application\Commands;

readonly class UpdateSystemParameterCommand
{
    public function __construct(
        public string $groups,
        public string $key,
        public string $value,
        public ?int $ordering = null,
        public ?string $description = null,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            groups: $request['groups'],
            key: $request['key'],
            value: $request['value'],
            ordering: $request['ordering'] ?? null,
            description: $request['description'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'groups' => $this->groups,
            'key' => $this->key,
            'value' => $this->value,
            'ordering' => $this->ordering,
            'description' => $this->description,
        ];
    }
}
