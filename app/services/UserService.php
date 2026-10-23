<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
   
    private array $relations = [
        'roles:role_id,role',
    ];

 
    public function index(): Collection
    {
        return User::with($this->relations)->get();
    }

   
    public function store(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return DB::transaction(function () use ($data) {
            $user = User::create($data);

            return $user->load($this->relations);
        });
    }

 
    public function show(int $id): User
    {
        return User::with($this->relations)->findOrFail($id);
    }

    
    public function update(int $id, array $input): User
    {
        $data = Validator::make($input, [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'password' => ['sometimes', 'string', 'min:8'],
            'role_id' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'boolean'],
        ])->validate();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return DB::transaction(function () use ($id, $data) {
            $user = User::findOrFail($id);

            $user->update($data);

            return $user->load($this->relations);
        });
    }

  
    public function destroy(int $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

  
    public function updatePassword(int $id, array $input): void
    {
        $data = Validator::make($input, [
            'password' => ['required', 'string', 'min:8'],
        ])->validate();

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);
    }
}