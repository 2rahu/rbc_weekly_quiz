<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class RolesController extends Controller
{
    use AuthorizesRequests;

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Roles::class);

        $roles = Roles::all();

        return response()->json([
            'status'  => true,
            'message' => 'Roles fetched successfully.',
            'data'    => $roles,
        ], 200);
    }

    
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Roles::class);

        $validated = $request->validate([
            'role' => ['required', 'string', 'max:50', 'unique:roles,role'],
        ]);

        $role = Roles::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Role saved successfully.',
            'data'    => $role->fresh(),
        ], 201);
    }

   
    public function show(int $id): JsonResponse
    {
        $role = Roles::findOrFail($id);

        $this->authorize('view', $role);

        return response()->json([
            'status'  => true,
            'message' => 'Role fetched successfully.',
            'data'    => $role,
        ], 200);
    }

  
    public function update(Request $request, int $id): JsonResponse
    {
        $role = Roles::findOrFail($id);

        $this->authorize('update', $role);

        $validated = $request->validate([
            'role' => [
                'required',
                'string',
                'max:50',
                Rule::unique('roles', 'role')
                    ->ignore($role->role_id, 'role_id'),
            ],
        ]);

        $role->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Role updated successfully.',
            'data'    => $role->fresh(),
        ], 200);
    }

  
    public function destroy(int $id): JsonResponse
    {
        $role = Roles::findOrFail($id);

        $this->authorize('delete', $role);

        $role->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Role deleted successfully.',
        ], 200);
    }
    
}
