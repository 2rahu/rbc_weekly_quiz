<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyQuizResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'question_id' => $this->question_id,
            'quiz_set_id' => $this->quiz_set_id,
            'quiz_set_date' => $this->quizSet->quiz_launch_date,
            'ques_id'     => $this->ques_id,
            'topic_id'    => $this->topic_id,
            'topic_name'    => $this->topics->topic_name,
            'question'    => $this->question,
            'filePath'    => $this->filePath,
            'option_1'    => $this->option_1,
            'option_2'    => $this->option_2,
            'option_3'    => $this->option_3,
            'option_4'    => $this->option_4,
            'answers'     => $this->answers,
        ];
    }
}
