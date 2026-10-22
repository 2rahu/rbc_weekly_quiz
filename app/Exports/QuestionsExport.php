<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class QuestionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('questions_by_editor')
            ->leftJoin(
                'quiz_topics',
                'questions_by_editor.topic_id',
                '=',
                'quiz_topics.topic_id'
            )
            ->select([
                'questions_by_editor.ques_id',
                'questions_by_editor.topic_id',
                'quiz_topics.topic_name',
                'questions_by_editor.user_id',
                'questions_by_editor.question',
                'questions_by_editor.filePath',
                'questions_by_editor.option_1',
                'questions_by_editor.option_2',
                'questions_by_editor.option_3',
                'questions_by_editor.option_4',
                'questions_by_editor.answers',
                'questions_by_editor.status',
                'questions_by_editor.created_at',
                'questions_by_editor.updated_at',
            ])
            ->orderBy('questions_by_editor.ques_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Question ID',
            'Topic ID',
            'Topic Name',
            'User ID',
            'Question',
            'File Path',
            'Option 1',
            'Option 2',
            'Option 3',
            'Option 4',
            'Answers',
            'Status',
            'Created At',
            'Updated At',
        ];
    }
}
