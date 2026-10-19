<?php

namespace App\Http\Requests\QuizEditorQuestion;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizEditorsQuestions extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'topic_id' => 'required|exists:quiz_topics,topic_id',
            'user_id' => 'required|exists:users,id',

            'question' => 'nullable|string',
            'filePath' => 'nullable|string|max:255',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'answers' => 'required|string',

            'status' => 'nullable|in:active,inactive',
        ];
    }
}