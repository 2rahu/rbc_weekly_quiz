<?php

namespace App\Models;

use App\Models\QuizTopic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TempModel extends Model
{
    use HasFactory;
    protected $table ='temp_question';
    protected $primaryKey = 'ques_id';

    public function topics(){
        return $this->belongsTo(QuizTopic::class, 'topic_id', 'topic_id');
    }
}
