<?php

namespace App\Modules\User\Presentation\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BaseJsonResource;

class UserResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'email' => $this->email,
            'username' => $this->username,
            'full_name' => $this->full_name,
            'is_active' => $this->is_active,
            'is_verified' => $this->is_verified,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'last_login_at' => $this->last_login_at,
            'login_attempts' => $this->login_attempts,
            'login_count' => $this->login_count,
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'code' => $role->code,
                        'name' => $role->name,
                    ];
                });
            }),
        ];
    }
}
