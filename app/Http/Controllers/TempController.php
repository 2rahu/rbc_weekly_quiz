<?php

namespace App\Http\Controllers;

use App\Models\quizSet;
use App\Models\TempModel;
use App\Models\QuizEditor;
use Illuminate\Http\Request;
use App\Models\QuestionModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TempController extends Controller
{
    
    public function index()
    {
            $selectedQuestions = TempModel::with('topics')->orderBy('created_at', 'desc')->get();

            return response()->json([
                'status' => true,
                'message' => 'Selected questions fetched successfully',
                'data' => $selectedQuestions,
            ]);

    }


    public function store(int $id)
    {
        try {
            $question = QuizEditor::findOrFail($id);

            $existingRecord = TempModel::where('ques_id', $question->ques_id)
                ->where('topic_id', $question->topic_id)
                ->where('question', $question->question)
                ->first();

            if ($existingRecord) {  
                return response()->json([
                    'status' => false,
                    'message' => 'Duplicate entry found',
                ], 409);
            }

            $data = new TempModel();

            $data->ques_id = $question->ques_id;
            $data->topic_id = $question->topic_id;
            $data->question = $question->question;
            $data->filePath = $question->filePath;
            $data->option_1 = $question->option_1;
            $data->option_2 = $question->option_2;
            $data->option_3 = $question->option_3;
            $data->option_4 = $question->option_4;
            $data->answer = $question->answer;

            $data->save();

            return response()->json([
                'status' => true,
                'message' => 'Question added to temporary list successfully',
                'data' => $data,
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function transfer(Request $request)
    {
        $request->validate([
            'quiz_launch_date' => 'required|date|unique:quiz_set,quiz_launch_date',
        ]);

        try {
            $tempQuestions = TempModel::all();

            if ($tempQuestions->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No questions found in temporary list',
                ], 422);
            }

            DB::beginTransaction();

            $quizSet = new quizSet();
            $quizSet->quiz_launch_date = $request->quiz_launch_date;
            $quizSet->save();

            $quizSetId = $quizSet->quiz_set_id;

            foreach ($tempQuestions as $temp) {

                $question = new QuestionModel();

                $question->quiz_set_id = $quizSetId;
                $question->ques_id = $temp->ques_id;
                $question->topic_id = $temp->topic_id;
                $question->question = $temp->question;
                $question->filePath = $temp->filePath;
                $question->option_1 = $temp->option_1;
                $question->option_2 = $temp->option_2;
                $question->option_3 = $temp->option_3;
                $question->option_4 = $temp->option_4;
                $question->answer = $temp->answer;
                $question->save();

                $editor = QuizEditor::find($temp->ques_id);

                if ($editor) {
                    $editor->status = 'inactive';
                    $editor->save();
                }
            }

            TempModel::truncate();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Questions transferred to quiz set successfully',
                'data' => [
                    'quiz_set_id' => $quizSetId,
                    'quiz_launch_date' => $quizSet->quiz_launch_date,
                    'questions_count' => $tempQuestions->count(),
                ],
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Questions transfer failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(int $id)
    {
        try {
            $tempQuestion = TempModel::findOrFail($id);
            $tempQuestion->delete();

            return response()->json([
                'status' => true,
                'message' => 'Temporary question deleted successfully',
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Temporary question not found',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}