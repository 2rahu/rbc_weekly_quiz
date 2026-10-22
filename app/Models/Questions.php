<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions';

    protected $primaryKey = 'question_id';

    public function quizSet()
    {
        return $this->belongsTo(
            quizSet::class,
            'quiz_set_id',
            'quiz_set_id'
        );
    }
}
