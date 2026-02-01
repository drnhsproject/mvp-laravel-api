<?php

namespace App\Modules\Privilege\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrivilegeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'module' => 'sometimes|required|string|max:255',
            'action' => 'sometimes|required|string|max:255',
            'submodule' => 'nullable|string|max:255',
            'method' => 'nullable|string|max:50',
            'uri' => 'nullable|string|max:255',
            'namespace' => 'nullable|string|max:255',
        ];
    }
}
