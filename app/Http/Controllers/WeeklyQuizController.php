<?php

namespace App\Http\Controllers;
use App\Models\QuizSet;
use App\Models\Questions;
use App\Http\Controllers\Controller;
use App\Http\Resources\WeeklyQuizResource;

class WeeklyQuizController extends Controller
{

     public function getWeeklyQuiz(int $quiz_set_id)
    {
        
        $quizSet = QuizSet::findorFail($quiz_set_id);

       if ((int) $quizSet->is_active !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'This quiz is currently inactive.',
                'data' => []
            ], 403);
        }

        $questions = Questions::where('quiz_set_id', $quiz_set_id)
            ->where('status', 'active')
            ->get();

        if ($questions->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No active questions found for this quiz set.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Weekly quiz questions fetched successfully.',
            'data' => WeeklyQuizResource::collection($questions)
        ], 200);
    }
    
}



