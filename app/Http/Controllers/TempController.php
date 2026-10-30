<?php

namespace App\Http\Controllers;

use Throwable;
use RuntimeException;
use App\Models\QuizSet;
use App\Models\QuizEditor;
use Illuminate\Http\Request;
use App\Services\TempService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\SelectedQuestionsResource;

class TempController extends Controller
{
    protected TempService $tempService;

    public function __construct(TempService $tempService)
    {
        $this->tempService = $tempService;
    }

    public function index(): JsonResponse
    {
        
            $selectedQuestions = $this->tempService->index();

            return response()->json([
                'status' => true,
                'message' => 'Selected questions fetched successfully.',
                'data' => SelectedQuestionsResource::collection($selectedQuestions),
            ], 200);

    }

    public function store(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'file' => [
                    'nullable',
                    'file',
                    'mimes:jpg,jpeg,png,webp,pdf',
                    'max:5120',
                ],
            ]);

            $question = QuizEditor::find($id);

            if (!$question) {
                return response()->json([
                    'status' => false,
                    'message' => 'Question not found.',
                ], 404);
            }

            $result = $this->tempService->store(
                $question,
                $request->file('file')
            );

            return response()->json(
                $result['body'],
                $result['http_code']
            );
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed. Please check the provided input.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred while selecting the question.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error.',
            ], 500);
        }
    }

    public function transfer(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'quiz_launch_date' => [
                    'required',
                    'date',
                    'unique:quiz_set,quiz_launch_date',
                ],
            ]);

            $result = $this->tempService->transfer(
                $validated['quiz_launch_date']
            );

            return response()->json([
                'status' => true,
                'message' => 'Questions and file paths transferred successfully.',
                'data' => $result,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed. Please check the provided input.',
                'errors' => $e->errors(),
            ], 422);
        } catch (RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred while transferring the questions.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error.',
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->tempService->destroy($id);

            if (!$deleted) {
                return response()->json([
                    'status' => false,
                    'message' => 'Selected question not found.',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Question removed from the temporary selection successfully.',
            ], 200);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred while removing the question.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error.',
            ], 500);
        }
    }
}
