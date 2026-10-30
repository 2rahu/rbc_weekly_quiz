<?php

namespace App\Http\Controllers;

use App\Models\QuizEditor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\QuizEditorService;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizEditorsResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\QuizEditorQuestion\StoreQuizEditorsQuestions;
use App\Http\Requests\QuizEditorQuestion\UpdateQuizEditorsQuestions;

class QuizEditorsController extends Controller
{
     use AuthorizesRequests;
    public function __construct(
        private readonly QuizEditorService $quizEditorService
    ) {}

  
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', QuizEditor::class);

        $questions = $this->quizEditorService->index();

        return response()->json([
            'status' => true,
            'message' => 'Questions fetched successfully.',
            'data' => QuizEditorsResource::collection($questions),
        ], 200);
    }

  
    public function store(StoreQuizEditorsQuestions $request): JsonResponse
    {
        $this->authorize('create', QuizEditor::class);

        try {
            $question = $this->quizEditorService->store(
                $request->validated()
            );

            return response()->json([
                'status' => true,
                'message' => 'Question created successfully.',
                'data' => new QuizEditorsResource($question),
            ], 201);

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while creating the question.'
            );
        }
    }

 
    public function show(int $id): JsonResponse
    {
        try {
            $question = $this->quizEditorService->show($id);

            $this->authorize('view', $question);

            return response()->json([
                'status' => true,
                'message' => 'Question fetched successfully.',
                'data' => new QuizEditorsResource($question),
            ], 200);

        } catch (AuthorizationException $e) {
            return $this->forbidden();

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while fetching the question.'
            );
        }
    }

 
    public function update(
        UpdateQuizEditorsQuestions $request,
        int $id
    ): JsonResponse {
        try {
            $question = $this->quizEditorService->show($id);

            $this->authorize('update', $question);

            $question = $this->quizEditorService->update(
                $id,
                $request->validated()
            );

            return response()->json([
                'status' => true,
                'message' => 'Question updated successfully.',
                'data' => new QuizEditorsResource($question),
            ], 200);

        } catch (AuthorizationException $e) {
            return $this->forbidden();

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while updating the question.'
            );
        }
    }

    public function update_image(Request $request, int $id): JsonResponse
    {
        try {
            $question = $this->quizEditorService->show($id);

            $this->authorize('update', $question);

            $data = $this->quizEditorService->updateImage($request, $id);

            return response()->json([
                'status' => true,
                'message' => 'Question image updated successfully.',
                'data' => $data,
            ], 200);

        } catch (AuthorizationException $e) {
            return $this->forbidden();

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed. Please check the uploaded image.',
                'errors' => $e->errors(),
            ], 422);

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while updating the question image.'
            );
        }
    }

   
    public function destroy(int $id): JsonResponse
    {
        try {
            $question = $this->quizEditorService->show($id);

            $this->authorize('delete', $question);

            $this->quizEditorService->destroy($id);

            return response()->json([
                'status' => true,
                'message' => 'Question deleted successfully.',
            ], 200);

        } catch (AuthorizationException $e) {
            return $this->forbidden();

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while deleting the question.'
            );
        }
    }

 
    public function toggleStatus(int $id): JsonResponse
    {
        try {
            $question = $this->quizEditorService->show($id);

            $this->authorize('update', $question);

            $data = $this->quizEditorService->toggleStatus($id);

            return response()->json([
                'status' => true,
                'message' => 'Question status updated successfully.',
                'data' => $data,
            ], 200);

        } catch (AuthorizationException $e) {
            return $this->forbidden();

        } catch (ModelNotFoundException $e) {
            return $this->notFound();

        } catch (\Throwable $e) {
            return $this->serverError(
                $e,
                'An error occurred while updating the question status.'
            );
        }
    }

    private function forbidden(): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => 'You are not authorized to perform this action.',
        ], 403);
    }

    private function notFound(): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => 'Question not found.',
        ], 404);
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
