<?php

namespace App\Http\Requests\QuizEditorQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateQuizEditorsQuestions extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic_id' => 'sometimes|required|integer|exists:quiz_topics,topic_id',
            'user_id' => 'sometimes|required|integer|exists:users,id',

            'question' => ['sometimes', 'nullable', 'string', 'regex:/\S/'],    

            'filePath' => 'sometimes|nullable|string|max:255',

            'option_1' => ['sometimes', 'required', 'string', 'regex:/\S/'],
            'option_2' => ['sometimes', 'required', 'string', 'regex:/\S/'],
            'option_3' => ['sometimes', 'required', 'string', 'regex:/\S/'],
            'option_4' => ['sometimes', 'required', 'string', 'regex:/\S/'],

            'answers' => ['sometimes', 'required', 'string', 'regex:/\S/'],

            'status' => 'sometimes|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'topic_id.required' => 'Topic ID is required.',
            'topic_id.exists' => 'The selected topic does not exist.',
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'The selected user does not exist.',

            'question.required' => 'Please enter a question.',
            'question.string' => 'Question must be valid text.',
            'question.regex' => 'Question cannot contain only spaces.',

            'option_1.required' => 'Please enter Option 1.',
            'option_1.regex' => 'Option 1 cannot contain only spaces.',
            'option_2.required' => 'Please enter Option 2.',
            'option_2.regex' => 'Option 2 cannot contain only spaces.',
            'option_3.required' => 'Please enter Option 3.',
            'option_3.regex' => 'Option 3 cannot contain only spaces.',
            'option_4.required' => 'Please enter Option 4.',
            'option_4.regex' => 'Option 4 cannot contain only spaces.',

            'answers.required' => 'Please enter the correct answer.',
            'answers.regex' => 'Answer cannot contain only spaces.',

            'filePath.max' => 'File path cannot exceed 255 characters.',
            'status.in' => 'Status must be either active or inactive.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check your input.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
