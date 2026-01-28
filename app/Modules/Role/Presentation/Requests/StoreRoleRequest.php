<?php

namespace App\Modules\Role\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorized by middleware/controller
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'privileges' => 'nullable|array',
            'privileges.*' => 'exists:privileges,id',
        ];
    }
}
