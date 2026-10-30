<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUsersRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UsersController extends Controller
{
    use AuthorizesRequests;
    
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->index();

        return response()->json([
            'status'  => true,
            'message' => 'Users fetched successfully.',
            'data'    => $users->makeHidden('role_id'),
        ], 200);
    }


    public function store(StoreUsersRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        try {
            $user = $this->userService->store(
                $request->validated()
            );

            return response()->json([
                'status'  => true,
                'message' => 'User created successfully.',
                'data'    => $user->makeHidden('role_id'),
            ], 201);

        } catch (ValidationException $e) {
            return $this->validationError($e);

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while creating the user.'
            );
        }
    }

  
    public function show(int $id): JsonResponse
    {
        $user = $this->findUser($id);

        $this->authorize('view', $user);

        return response()->json([
            'status'  => true,
            'message' => 'User fetched successfully.',
            'data'    => $user->makeHidden('role_id'),
        ], 200);
    }

 
    public function update(Request $request, int $id): JsonResponse
    {
        $user = $this->findUser($id);

        $this->authorize('update', $user);

        try {
            $updatedUser = $this->userService->update(
                $id,
                $request->all()
            );

            return response()->json([
                'status'  => true,
                'message' => 'User updated successfully.',
                'data'    => $updatedUser->makeHidden('role_id'),
            ], 200);

        } catch (ValidationException $e) {
            return $this->validationError($e);

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while updating the user.'
            );
        }
    }

  
    public function destroy(int $id): JsonResponse
    {
        $user = $this->findUser($id);

        $this->authorize('delete', $user);

        try {
            $this->userService->destroy($id);

            return response()->json([
                'status'  => true,
                'message' => 'User deleted successfully.',
            ], 200);

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while deleting the user.'
            );
        }
    }

 
    public function updatePassword(Request $request, int $id): JsonResponse {
        $user = $this->findUser($id);

        $this->authorize('update', $user);

        try {
            $this->userService->updatePassword(
                $id,
                $request->all()
            );

            return response()->json([
                'status'  => true,
                'message' => 'Password updated successfully.',
            ], 200);

        } catch (ValidationException $e) {
            return $this->validationError($e);

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while updating the password.'
            );
        }
    }

 
    private function findUser(int $id): User
    {
        return User::findOrFail($id);
    }


    private function validationError(
        ValidationException $e
    ): JsonResponse {
        return response()->json([
            'status'  => false,
            'message' => 'Validation failed.',
            'errors'  => $e->errors(),
        ], 422);
    }


    private function serverError(
        \Throwable $e,
        string $message
    ): JsonResponse {
        report($e);

        return response()->json([
            'status'  => false,
            'message' => $message,
            'error'   => config('app.debug')
                ? $e->getMessage()
                : 'Internal server error.',
        ], 500);
    }
    
}
