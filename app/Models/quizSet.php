<?php

namespace App\Models;

use App\Models\Questions;
use Illuminate\Database\Eloquent\Model;

class QuizSet extends Model
{
    protected $table = 'quiz_set';

    protected $primaryKey = 'quiz_set_id';

    protected $fillable = [
        'quiz_launch_date',
        'is_active',
    ];

    protected $casts = [
        'quiz_launch_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(
            Questions::class,
            'quiz_set_id',
            'quiz_set_id'
        );
    }
}
