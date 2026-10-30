<?php

namespace App\Http\Requests\Topics;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateQuizTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $value = $this->input('topic_name');

        if (is_string($value)) {
            $this->merge([
                'topic_name' => preg_replace('/\s+/', ' ', trim($value)),
            ]);
        }
    }

    public function rules(): array
    {
        $topicId = $this->route('quiz_topic')
            ?? $this->route('topic')
            ?? $this->route('id');

        return [
            'topic_name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                'regex:/\S/',
                Rule::unique('quiz_topics', 'topic_name')
                    ->ignore($topicId, 'topic_id'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'topic_name.required' => 'Please enter a topic name.',
            'topic_name.string' => 'Topic name must be valid text.',
            'topic_name.max' => 'Topic name cannot exceed 100 characters.',
            'topic_name.regex' => 'Topic name cannot contain only spaces.',
            'topic_name.unique' => 'This topic name already exists.',
        ];
    }

    protected function failedValidation(Validator $validator)
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
