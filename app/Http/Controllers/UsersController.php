<?php

namespace App\Http\Controllers;

use App\Models\User;    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\StoreUsersRequest;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::with('roles:role_id,role')->get();

        return response()->json([
            "status" => true,
            "message" => "user fetched successfully...",
            "data" => $users->makeHidden('role_id')
        ]);
    }


    public function store(StoreUsersRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

public function show(int $id)
{
    try {
        $user = User::with('roles:role_id,role')->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'User fetched successfully',
            'data' => $user->makeHidden('role_id'),
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => false,
            'message' => 'User not found',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function update(Request $request, int $id)
{
    try {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $id,
            'phone' => 'sometimes|nullable|string|max:20',
            'password' => 'sometimes|string|min:8',
            'role_id' => 'sometimes|integer',
            'status' => 'sometimes|boolean',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        $user->load('roles:role_id,role');

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user->makeHidden('role_id'),
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => false,
            'message' => 'User not found',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function destroy(int $id)
{
    try {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => false,
            'message' => 'User not found',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function updatePassword(Request $request, int $id)
{
    try {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully',
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

        return response()->json([
            'status' => false,
            'message' => 'User not found',
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
