<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUsersRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

   
    public function index(): JsonResponse
    {
       
            $users = $this->userService->index();

            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully.',
                'data' => $users->makeHidden('role_id'),
            ], 200);

      
    }

  
    public function store(StoreUsersRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->store(
                $request->validated()
            );

            return response()->json([
                'status' => true,
                'message' => 'User created successfully.',
                'data' => $user->makeHidden('role_id'),
            ], 201);

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while creating the user.'
            );
        }
    }


    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->show($id);

            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully.',
                'data' => $user->makeHidden('role_id'),
            ], 200);

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while fetching the user.'
            );
        }
    }

  
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->update(
                $id,
                $request->all()
            );

            return response()->json([
                'status' => true,
                'message' => 'User updated successfully.',
                'data' => $user->makeHidden('role_id'),
            ], 200);

        } catch (ValidationException $e) {
            return $this->validationError($e);

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while updating the user.'
            );
        }
    }

  
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userService->destroy($id);

            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully.',
            ], 200);

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while deleting the user.'
            );
        }
    }

    public function updatePassword(
        Request $request,
        int $id
    ): JsonResponse {
        try {
            $this->userService->updatePassword(
                $id,
                $request->all()
            );

            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully.',
            ], 200);

        } catch (ValidationException $e) {
            return $this->validationError($e);

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while updating the password.'
            );
        }
    }

    private function notFound(): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
        ], 404);
    }

    private function validationError(
        ValidationException $e
    ): JsonResponse {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed.',
            'errors' => $e->errors(),
        ], 422);
    }

    private function serverError(
        \Throwable $e,
        string $message
    ): JsonResponse {
        report($e);

        return response()->json([
            'status' => false,
            'message' => $message,
            'error' => config('app.debug')
                ? $e->getMessage()
                : 'Internal server error.',
        ], 500);
    }

}