<?php

namespace App\Http\Controllers;

use App\Models\QuizTopic;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class QuizTopicController extends Controller
{
    /**
     * Fetch all quiz topics.
     */
    public function index(): JsonResponse
    {
        try {
            $topics = QuizTopic::all();

            return response()->json([
                'status' => true,
                'message' => 'Quiz topics fetched successfully.',
                'count' => $topics->count(),
                'data' => $topics,
            ], 200);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching quiz topics.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error.',
            ], 500);
        }
    }

   
    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'topic_name' => 'required|string|max:100',
            ]);

            $topic = QuizTopic::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Quiz topic created successfully.',
                'data' => $topic,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed. Please check the provided input.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the quiz topic.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error.',
            ], 500);
        }
    }

    /**
     * Fetch a specific quiz topic.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $topic = QuizTopic::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Quiz topic fetched successfully.',
                'data' => $topic,
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz topic not found.',
            ], 404);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching the quiz topic.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error.',
            ], 500);
        }
    }


    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $topic = QuizTopic::findOrFail($id);

            $data = $request->validate([
                'topic_name' => 'required|string|max:100',
            ]);

            $topic->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Quiz topic updated successfully.',
                'data' => $topic,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed. Please check the provided input.',
                'errors' => $e->errors(),
            ], 422);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz topic not found.',
            ], 404);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the quiz topic.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error.',
            ], 500);
        }
    }

   
    public function destroy(int $id): JsonResponse
    {
        try {
            $topic = QuizTopic::findOrFail($id);

            $topic->delete();

            return response()->json([
                'status' => true,
                'message' => 'Quiz topic deleted successfully.',
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz topic not found.',
            ], 404);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the quiz topic.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error.',
            ], 500);
        }
    }
    
}
