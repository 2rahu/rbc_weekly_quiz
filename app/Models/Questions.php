<?php

namespace App\Models;

use App\Models\QuizTopic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Questions extends Model
{
    use HasFactory;
    protected $table ='questions';
    protected $primaryKey ='ques_id';

    public function quiztopics(){
        return $this->belongsTo(QuizTopic::class, 'topic_id', 'topic_id');
    }

    public function quizset(){
        return $this->belongsTo(quizSet::class,'quiz_set_id', 'quiz_set_id');
    }

    
}
