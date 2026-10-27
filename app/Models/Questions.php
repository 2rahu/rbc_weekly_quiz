<?php

namespace App\Models;

use App\Models\QuizSet;
use App\Models\QuizTopic;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions';

    protected $primaryKey = 'question_id';

    protected $fillable = [
        'quiz_set_id',
        'ques_id',
        'topic_id',
        'question',
        'filePath',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'answers',
        'is_running',
        'status',
    ];

    public function quizSet()
    {
        return $this->belongsTo(
            QuizSet::class,
            'quiz_set_id',
            'quiz_set_id'
        );
    }

      public function topics()
    {
        return $this->belongsTo(
            QuizTopic::class,
            'topic_id',
            'topic_id'
        );
    }

    
}
