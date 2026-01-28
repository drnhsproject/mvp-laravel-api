<?php

namespace App\Modules\Role\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role'); // Assuming route param is 'role' or ID

        return [
            'name' => 'sometimes|required|string|max:255|unique:roles,name,' . $roleId,
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'privileges' => 'nullable|array',
            'privileges.*' => 'exists:privileges,id',
        ];
    }
}
