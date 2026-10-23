<?php

namespace App\Http\Controllers;

use App\Models\QuizSet;
use App\Models\Questions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuizSetController extends Controller
{   

    public function index()
    {

        $quizSets = QuizSet::all();

        return response()->json([
            'status' => true,
            'message' => 'Quiz sets fetched successfully',
            'data' => $quizSets,
        ]);
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'quiz_launch_date' => 'required|date',
        ]);

        $quizSet = QuizSet::create($data);
    
        return response()->json([
            'status' => true,
            'message' => 'Quiz set created successfully',
            'data' => $quizSet,
        ], 201);
    }


    public function show(int $id)
    {
        try {
            $quizSet = QuizSet::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Quiz set fetched successfully',
                'data' => $quizSet,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz set not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, int $id)
    {
        try {
            $quizSet = QuizSet::findOrFail($id);

            $data = $request->validate([
                'quiz_launch_date' => 'required|date',    
            ]);

            $quizSet->update($data);

            return response()->json([       
                'status' => true,
                'message' => 'Quiz set updated successfully',
                'data' => $quizSet,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz set not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(int $id)
    {
        try {
            $quizSet = QuizSet::findOrFail($id);

            $quizSet->delete();

            return response()->json([
                'status' => true,
                'message' => 'Quiz set deleted successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz set not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function changeQuizSetStatus(int $id)
    {
        $quizSet = QuizSet::findOrFail($id);
        $quizSet->is_active = !$quizSet->is_active;
        $quizSet->save();

        return response()->json([
            'status' => true,
            'message' => 'Quiz set status updated successfully',
        ]);
    }


    public function weeklyquiz(int $id)
    {
        $quiz_set = QuizSet::where('quiz_set_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($quiz_set && $quiz_set->is_active == 1) {
            $allQuestions = Questions::with('quiztopics')
                ->where('quiz_set_id', $quiz_set->quiz_set_id)
                ->get();

            return view('test')->with(compact('allQuestions'));
        } else {
            return view('inactive_quizes');
        }

        return redirect()->route('weekly.quiz');
    }
}


