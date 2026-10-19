<?php

namespace App\Models;

use App\Models\User;
use App\Models\QuizTopic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizEditor extends Model
{
    use HasFactory;

    protected $table = 'questions_by_editor';
    protected $primaryKey = 'ques_id';

    protected $fillable = [
        'topic_id',
        'user_id',
        'question',
        'filePath',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'answers',
        'status',
    ];

    public function topics()
    {
        return $this->belongsTo(
            QuizTopic::class,
            'topic_id',
            'topic_id'
        );
    }

    public function users()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }
}