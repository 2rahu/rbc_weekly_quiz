<?php

namespace App\Services;

use App\Models\QuizEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class QuizEditorService
{
    
    private array $relations = [
        'topics',
        'users',
    ];


    public function index(): Collection
    {
        return QuizEditor::with($this->relations)->get();
    }

   
    public function store(array $data): QuizEditor
    {
        return DB::transaction(function () use ($data) {
            $question = QuizEditor::create($data);

            return $question->load($this->relations);
        });
    }


    public function show(int $id): QuizEditor
    {
        return QuizEditor::with($this->relations)->findOrFail($id);
    }


    public function update(int $id, array $data): QuizEditor
    {
        return DB::transaction(function () use ($id, $data) {
            $question = QuizEditor::findOrFail($id);

            $question->update($data);

            return $question->load($this->relations);
        });
    }

   
    public function updateImage(Request $request, int $id): array
    {
        // dd("dwjncde");
        $request->validate([
            'file_path' => [
                'required',
                'image',
                'mimes:png',
                'max:2048',
            ],
        ]);

        $question = QuizEditor::findOrFail($id);
        $file = $request->file('file_path');

        // $imageSize = getimagesize($file->getRealPath());

        // if (
        //     $imageSize === false ||
        //     $imageSize[0] > 500 ||
        //     $imageSize[1] > 300
        // ) {
        //     throw ValidationException::withMessages([
        //         'file_path' => [
        //             'The image dimensions must not exceed 500x300 pixels.',
        //         ],
        //     ]);
        // }

        $imageName = $question->ques_id . '.png';
 
        $filePath = $file->storeAs(
            'quiz_images_uploads',
            $imageName,
            'public'
        );

        if (!$filePath) {
            throw new \RuntimeException(
                'The image could not be uploaded.'
            );
        }

        $question->filePath = $filePath;
        $question->save();

        return [
            'ques_id' => $question->ques_id,
            'filePath' => $question->filePath,
            'file_url' => asset('storage/' . $question->filePath),
        ];
    }

   
    public function destroy(int $id): void
    {
        $question = QuizEditor::findOrFail($id);

        $question->delete();
    }

  
    public function toggleStatus(int $id): array
    {
        $question = QuizEditor::findOrFail($id);

        $question->status = $question->status === 'active'
            ? 'inactive'
            : 'active';

        $question->save();

        return [
            'ques_id' => $question->ques_id,
            'status' => $question->status,
        ];
    }
    
}