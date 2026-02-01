<?php

namespace App\Modules\Privilege\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrivilegeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'module' => 'required|string|max:255',
            'action' => 'required|string|max:255',
            'submodule' => 'nullable|string|max:255',
            'method' => 'nullable|string|max:50',
            'uri' => 'nullable|string|max:255',
            'namespace' => 'nullable|string|max:255', // Now user.list etc.
        ];
    }
}
