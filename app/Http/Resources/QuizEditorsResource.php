<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizEditorsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ques_id' => $this->ques_id,
            'topic_id' => $this->topic_id,
            'topic_name' => $this->topics?->topic_name,
            'user_id' => $this->user_id,
            'username' => $this->users->name,

            'question' => $this->question,
            'filePath' => $this->filePath,

            'option_1' => $this->option_1,
            'option_2' => $this->option_2,
            'option_3' => $this->option_3,
            'option_4' => $this->option_4,

            'answers' => $this->answers,
            'status' => $this->status,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
