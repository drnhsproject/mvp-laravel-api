<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUser
{
    public function execute(array $data): User
    {
        return User::create([
            'full_name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
