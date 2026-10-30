<?php

namespace App\Http\Controllers;

use App\Models\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;

class QuestionsController extends Controller
{
    public function index()
    {
        $questions = Questions::with(['quizSet', 'topics'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Questions fetched successfully',
            'data' => QuestionResource::collection($questions),
        ]);
    }
}