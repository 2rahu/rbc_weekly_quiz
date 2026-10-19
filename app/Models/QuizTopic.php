<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizTopic extends Model
{

    use HasFactory;
    protected $table ='quiz_topics';
    protected $primaryKey = 'topic_id';

    protected $fillable = [
        'topic_name',
    ];

    

    
}
