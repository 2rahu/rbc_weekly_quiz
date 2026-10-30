<?php

namespace App\Http\Requests\Users;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $fields = [
            'name',
            'email',
        ];

        foreach ($fields as $field) {
            $value = $this->input($field);

            if (is_string($value)) {
                $this->merge([
                    $field => preg_replace('/\s+/', ' ', trim($value)),
                ]);
            }
        }
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:50',
            ],

            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'password' => [
                'sometimes',
                'string',
                'min:8',
            ],

            'role_id' => [
                'sometimes',
                'integer',
                'exists:roles,role_id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Name must be valid text.',
            'name.max' => 'Name cannot exceed 50 characters.',

            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',

            'password.min' => 'Password must be at least 8 characters.',

            'role_id.integer' => 'Role ID must be an integer.',
            'role_id.exists' => 'The selected role does not exist.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422)
        );
    }
    
}
