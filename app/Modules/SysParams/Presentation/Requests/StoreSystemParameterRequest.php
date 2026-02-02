<?php

namespace App\Modules\SysParams\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSystemParameterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'groups' => ['required', 'string', 'max:255'],
            'key' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sysparams', 'key')
                    ->whereNull('deleted_at'),
            ],
            'value' => ['required', 'string'],
            'ordering' => ['nullable', 'integer'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'groups.required' => 'The groups field is required.',
            'key.required' => 'The key field is required.',
            'value.required' => 'The value field is required.',
            'ordering.integer' => 'The ordering must be an integer.',
        ];
    }
}
