<?php

namespace App\Http\Requests\Users;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name' => 'sometimes|string|max:50',
            'email' => ['required','email',Rule::unique('users', 'email')->ignore($userId)],
            'password' => 'sometimes|string|min:8',
            'role_id' => ['sometimes','integer','exists:roles,role_id',],
        ];
    }
}

