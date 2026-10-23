<?php

namespace App\Http\Controllers;

use App\Models\QuizSet;
use App\Models\Questions;
use App\Models\TempModel;
use App\Models\QuizEditor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class TempController extends Controller
{
 
    public function index(): JsonResponse
    {
        $selectedQuestions = TempModel::with('quiztopics')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Selected questions fetched successfully.',
            'count' => $selectedQuestions->count(),
            'data' => $selectedQuestions,
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

            $existingRecord = TempModel::where(
                'ques_id',
                $question->ques_id
            )
                ->where('topic_id', $question->topic_id)
                ->first();

            if ($existingRecord) {
                return response()->json([
                    'status' => false,
                    'message' => 'This question has already been added to the temporary selection.',
                ], 409);
            }

            // Use the existing file path unless a new file is uploaded.
            $filePath = $question->filePath;
            $newFileUploaded = false;

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')
                    ->store('questions', 'public');

                $newFileUploaded = true;
            }

            try {
                $data = new TempModel();

                $data->ques_id = $question->ques_id;
                $data->topic_id = $question->topic_id;
                $data->question = $question->question;
                $data->filePath = $filePath;
                $data->option_1 = $question->option_1;
                $data->option_2 = $question->option_2;
                $data->option_3 = $question->option_3;
                $data->option_4 = $question->option_4;
                $data->answers = $question->answers;

                $data->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Question added to the temporary selection successfully.',
                    'data' => $data,
                    'file_url' => $filePath
                        ? asset('storage/' . $filePath)
                        : null,
                ], 201);

            } catch (\Throwable $e) {
                // Remove a newly uploaded file if saving fails.
                if ($newFileUploaded && $filePath) {
                    Storage::disk('public')->delete($filePath);
                }

                throw $e;
            }

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

            $result = DB::transaction(function () use ($validated) {
                $tempQuestions = TempModel::all();

                if ($tempQuestions->isEmpty()) {
                    throw new \RuntimeException(
                        'No questions are available in the temporary selection.'
                    );
                }

                $quizSet = new QuizSet();
                $quizSet->quiz_launch_date =
                    $validated['quiz_launch_date'];
                $quizSet->save();

                foreach ($tempQuestions as $temp) {
                    $question = new Questions();

                    $question->quiz_set_id = $quizSet->quiz_set_id;
                    $question->ques_id = $temp->ques_id;
                    $question->topic_id = $temp->topic_id;
                    $question->question = $temp->question;

                    // Preserve the uploaded file path.
                    $question->filePath = $temp->filePath;

                    $question->option_1 = $temp->option_1;
                    $question->option_2 = $temp->option_2;
                    $question->option_3 = $temp->option_3;
                    $question->option_4 = $temp->option_4;
                    $question->answers = $temp->answers;

                    $question->save();

                    $editor = QuizEditor::find($temp->ques_id);

                    if ($editor) {
                        $editor->status = 'disabled';
                        $editor->save();
                    }
                }

                $totalQuestions = $tempQuestions->count();

                // Delete temporary records after transferring the questions.
                TempModel::query()->delete();

                return [
                    'quiz_set_id' => $quizSet->quiz_set_id,
                    'quiz_launch_date' => $quizSet->quiz_launch_date,
                    'total_questions' => $totalQuestions,
                ];
            });

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

        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);

        } catch (\Throwable $e) {
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
            $tempQuestion = TempModel::find($id);

            if (!$tempQuestion) {
                return response()->json([
                    'status' => false,
                    'message' => 'Selected question not found.',
                ], 404);
            }

            $tempQuestion->delete();

            return response()->json([
                'status' => true,
                'message' => 'Question removed from the temporary selection successfully.',
            ], 200);

        } catch (\Throwable $e) {
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
