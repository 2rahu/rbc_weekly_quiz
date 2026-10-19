<?php

namespace App\Models;

use App\Models\Questions;
use Illuminate\Database\Eloquent\Model;

class quizSet extends Model
{
    protected $table = 'quiz_set';
    protected $primaryKey = 'quiz_set_id';

    protected $fillable = [
        'quiz_launch_date'
    ];

    public function questions()
    {
        return $this->hasMany(Questions::class, 'quiz_Code', 'id');
    }
}
