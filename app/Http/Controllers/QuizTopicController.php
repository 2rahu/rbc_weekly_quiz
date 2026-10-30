<?php

namespace App\Http\Controllers;

use App\Models\QuizTopic;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Topics\StoreQuizTopicRequest;
use App\Http\Requests\Topics\UpdateQuizTopicRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuizTopicController extends Controller
{
    use AuthorizesRequests;

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', QuizTopic::class);

        $topics = QuizTopic::all();

        return response()->json([
            'status' => true,
            'message' => 'Quiz topics fetched successfully.',
            'data' => $topics,
        ], 200);
    }

    public function store(StoreQuizTopicRequest $request): JsonResponse
    {
        $this->authorize('create', QuizTopic::class);

        $topic = QuizTopic::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Quiz topic created successfully.',
            'data' => $topic,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $topic = QuizTopic::findOrFail($id);

        $this->authorize('view', $topic);

        return response()->json([
            'status' => true,
            'message' => 'Quiz topic fetched successfully.',
            'data' => $topic,
        ], 200);
    }

    public function update(UpdateQuizTopicRequest $request, int $id): JsonResponse
    {
        $topic = QuizTopic::findOrFail($id);

        $this->authorize('update', $topic);

        $topic->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Quiz topic updated successfully.',
            'data' => $topic->refresh(),
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $topic = QuizTopic::findOrFail($id);

        $this->authorize('delete', $topic);

        $topic->delete();

        return response()->json([
            'status' => true,
            'message' => 'Quiz topic deleted successfully.',
        ], 200);
    }
}
