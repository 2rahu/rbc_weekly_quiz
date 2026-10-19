<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    public function index()
    {
            $roles = Roles::all();

            return response()->json([
                "status" => true,
                "message" => "Roles fetched successfully.",
                "data" => $roles
            ], 200);

    }


    public function store(Request $request)
    {
            $validate = $request->validate([
                'role' => 'required|string|unique:roles,role|max:50',
            ]);

            $role = Roles::create($validate);

            return response()->json([
                "status" => true,
                "message" => "Role saved successfully.",
                "data" => $role->fresh()
            ], 201);

    }


    public function show(int $id)
    {
        try {
            $role = Roles::findOrFail($id);

            return response()->json([
                "status" => true,
                "message" => "Role fetched successfully.",
                "data" => $role
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Role not found."
            ], 404);

        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong.",
                "error" => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, int $id)
    {
        try {
            $role = Roles::findOrFail($id);

            $validate = $request->validate([
                'role' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('roles', 'role')->ignore($role->role_id, 'role_id'),
                ],
            ]);

            $role->update($validate);

            return response()->json([
                "status" => true,
                "message" => "Role updated successfully.",
                "data" => $role->fresh()
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Role not found."
            ], 404);

        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong.",
                "error" => $e->getMessage()
            ], 500);
        }
    }


    public function destroy(int $id)
    {
        try {
            $role = Roles::findOrFail($id);

            $role->delete();

            return response()->json([
                "status" => true,
                "message" => "Role deleted successfully."
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Role not found."
            ], 404);

        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong.",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}