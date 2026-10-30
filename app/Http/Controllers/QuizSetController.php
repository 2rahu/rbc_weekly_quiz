<?php

namespace App\Http\Controllers;

use App\Models\QuizSet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class QuizSetController extends Controller
{
     use AuthorizesRequests;

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', QuizSet::class);

        $quizSets = QuizSet::all();

        return response()->json([
            'status'  => true,
            'message' => 'Quiz sets fetched successfully.',
            'data'    => $quizSets,
        ], 200);
    }

   
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', QuizSet::class);

        $data = $request->validate([
            'quiz_launch_date' => ['required', 'date'],
        ]);

        $quizSet = QuizSet::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Quiz set created successfully.',
            'data'    => $quizSet,
        ], 201);
    }

  
    public function show(int $id): JsonResponse
    {
        $quizSet = QuizSet::findOrFail($id);

        $this->authorize('view', $quizSet);

        return response()->json([
            'status'  => true,
            'message' => 'Quiz set fetched successfully.',
            'data'    => $quizSet,
        ], 200);
    }

  
    public function update(Request $request, int $id): JsonResponse
    {
        $quizSet = QuizSet::findOrFail($id);

        $this->authorize('update', $quizSet);

        $data = $request->validate([
            'quiz_launch_date' => ['required', 'date'],
        ]);

        $quizSet->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Quiz set updated successfully.',
            'data'    => $quizSet->fresh(),
        ], 200);
    }

    
    public function destroy(int $id): JsonResponse
    {
        $quizSet = QuizSet::findOrFail($id);

        $this->authorize('delete', $quizSet);

        $quizSet->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Quiz set deleted successfully.',
        ], 200);
    }

    
    public function changeQuizSetStatus(int $id): JsonResponse
    {
        $quizSet = QuizSet::findOrFail($id);

        $this->authorize('update', $quizSet);

        $quizSet->is_active = ! $quizSet->is_active;
        $quizSet->save();

        return response()->json([
            'status'  => true,
            'message' => 'Quiz set status updated successfully.',
            'data'    => $quizSet->fresh(),
        ], 200);
    }

  
   
    
}
