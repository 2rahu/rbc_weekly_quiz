<?php

namespace App\Services;

use Throwable;
use RuntimeException;
use App\Models\QuizSet;
use App\Models\Questions;
use App\Models\TempModel;
use App\Models\QuizEditor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TempService
{
    public function index()
    {
        return TempModel::with('quiztopics')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store(
        QuizEditor $question,
        ?UploadedFile $file = null
    ): array {
        $existingRecord = TempModel::where(
            'ques_id',
            $question->ques_id
        )
            ->where('topic_id', $question->topic_id)
            ->exists();

        if ($existingRecord) {
            return [
                'http_code' => 409,
                'body' => [
                    'status' => false,
                    'message' => 'This question has already been added to the temporary selection.',
                ],
            ];
        }

        $filePath = $question->filePath;
        $newFileUploaded = false;

        if ($file) {
            $filePath = $file->store('questions', 'public');
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

            return [
                'http_code' => 201,
                'body' => [
                    'status' => true,
                    'message' => 'Question added to the temporary selection successfully.',
                    'data' => $data,
                    'file_url' => $filePath
                        ? asset('storage/' . $filePath)
                        : null,
                ],
            ];
        } catch (Throwable $e) {
            if ($newFileUploaded && $filePath) {
                Storage::disk('public')->delete($filePath);
            }

            throw $e;
        }
    }

    public function transfer(string $launchDate): array
    {
        return DB::transaction(function () use ($launchDate) {
            $tempQuestions = TempModel::all();

            if ($tempQuestions->isEmpty()) {
                throw new RuntimeException(
                    'No questions are available in the temporary selection.'
                );
            }

            $quizSet = new QuizSet();
            $quizSet->quiz_launch_date = $launchDate;
            $quizSet->save();

            foreach ($tempQuestions as $temp) {
                $question = new Questions();

                $question->quiz_set_id = $quizSet->quiz_set_id;
                $question->ques_id = $temp->ques_id;
                $question->topic_id = $temp->topic_id;
                $question->question = $temp->question;
                $question->filePath = $temp->filePath;
                $question->option_1 = $temp->option_1;
                $question->option_2 = $temp->option_2;
                $question->option_3 = $temp->option_3;
                $question->option_4 = $temp->option_4;
                $question->answers = $temp->answers;

                $question->save();

                // Find the editor by its question and topic IDs.
                $editor = QuizEditor::where(
                    'ques_id',
                    $temp->ques_id
                )
                    ->where('topic_id', $temp->topic_id)
                    ->first();

                if ($editor) {
                    $editor->status = 'disabled';
                    $editor->save();
                }
            }

            $totalQuestions = $tempQuestions->count();

            TempModel::query()->delete();

            return [
                'quiz_set_id' => $quizSet->quiz_set_id,
                'quiz_launch_date' => $quizSet->quiz_launch_date,
                'total_questions' => $totalQuestions,
            ];
        });
    }

    public function destroy(int $id): bool
    {
        $tempQuestion = TempModel::find($id);

        if (!$tempQuestion) {
            return false;
        }

        $tempQuestion->delete();

        return true;
    }
}
