<?php

namespace App\Http\Requests\QuizEditorQuestion;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizEditorsQuestions extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic_id' => 'sometimes|exists:quiz_topics,topic_id',
            'user_id' => 'sometimes|exists:users,id',

            'question' => 'sometimes|string',

            'filePath' => 'nullable|string|max:255',

            'option_1' => 'sometimes|string',
            'option_2' => 'sometimes|string',
            'option_3' => 'sometimes|string',
            'option_4' => 'sometimes|string',

            'answers' => 'sometimes|string',

            'status' => 'sometimes|in:active,inactive',
        ];
    }
}