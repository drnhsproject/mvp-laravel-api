<?php

namespace App\Modules\User\Application\Commands;

readonly class CreateUserCommand
{
    public function __construct(
        public string $fullName,
        public string $email,
        public string $username,
        public string $password,
        public bool $isActive,
        public bool $isVerified
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            fullName: $request['full_name'],
            email: $request['email'],
            username: $request['username'],
            password: $request['password'],
            isActive: $request['is_active'] ?? false,
            isVerified: $request['is_verified'] ?? false
        );
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'is_active' => $this->isActive,
            'is_verified' => $this->isVerified,
        ];
    }
}
