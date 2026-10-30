<?php

namespace App\Http\Requests\QuizEditorQuestion;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreQuizEditorsQuestions extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $fields = [
            'question',
            'option_1',
            'option_2',
            'option_3',
            'option_4',
            'answers',
        ];

        $normalized = [];

        foreach ($fields as $field) {
            $value = $this->input($field);

            if (is_string($value)) {
                $normalized[$field] = preg_replace(
                    '/\s+/',
                    ' ',
                    trim($value)
                );
            }
        }

        $this->merge($normalized);
    }

    public function rules(): array
    {
        return [
            'topic_id' => [
                'required',
                'integer',
                'exists:quiz_topics,topic_id',
            ],

            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'question' => [
                'nullable',
                'string',
                'regex:/\S/',
                Rule::unique('questions_by_editor', 'question')
                    ->where(function ($query) {
                        return $query->where(
                            'topic_id',
                            $this->input('topic_id')
                        );
                    }),
            ],

            'filePath' => [
                'nullable',
                'string',
                'max:255',
            ],

            'option_1' => [
                'required',
                'string',
                'regex:/\S/',
            ],

            'option_2' => [
                'required',
                'string',
                'regex:/\S/',
            ],

            'option_3' => [
                'required',
                'string',
                'regex:/\S/',
            ],

            'option_4' => [
                'required',
                'string',
                'regex:/\S/',
            ],

            'answers' => [
                'required',
                'string',
                'regex:/\S/',
            ],

            'status' => [
                'nullable',
                Rule::in(['active', 'inactive']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'topic_id.required' => 'Topic is required.',
            'topic_id.integer' => 'Topic ID must be an integer.',
            'topic_id.exists' => 'Selected topic does not exist.',

            'user_id.required' => 'User is required.',
            'user_id.integer' => 'User ID must be an integer.',
            'user_id.exists' => 'Selected user does not exist.',

            'question.string' => 'Question must be a string.',
            'question.regex' => 'Question cannot contain only spaces.',
            'question.unique' => 'This question already exists in the selected topic.',

            'filePath.string' => 'File path must be a string.',
            'filePath.max' => 'File path cannot exceed 255 characters.',

            'option_1.required' => 'Option 1 is required.',
            'option_1.regex' => 'Option 1 cannot contain only spaces.',

            'option_2.required' => 'Option 2 is required.',
            'option_2.regex' => 'Option 2 cannot contain only spaces.',

            'option_3.required' => 'Option 3 is required.',
            'option_3.regex' => 'Option 3 cannot contain only spaces.',

            'option_4.required' => 'Option 4 is required.',
            'option_4.regex' => 'Option 4 cannot contain only spaces.',

            'answers.required' => 'Correct answer is required.',
            'answers.regex' => 'Correct answer cannot contain only spaces.',

            'status.in' => 'Status must be active or inactive.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}