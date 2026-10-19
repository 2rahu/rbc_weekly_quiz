<?php

namespace App\Http\Controllers;

use App\Models\QuizEditor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizEditorsResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\QuizEditorQuestion\StoreQuizEditorsQuestions;
use App\Http\Requests\QuizEditorQuestion\UpdateQuizEditorsQuestions;

class QuizEditorsController extends Controller
{

    public function index()
    {
        $questions = QuizEditor::with([
            'topics',
            'users'
        ])->get();

        return response()->json([
            'status' => true,
            'message' => 'Questions fetched successfully',
            'data' => QuizEditorsResource::collection($questions),
        ]);
    }

    public function store(StoreQuizEditorsQuestions $request)
    {

        $data = $request->validated();
        // $data['user_id']  => Auth::id();
        $question = QuizEditor::create($data);

        $question->load([
            'topics',
            'users'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Question created successfully',
            'data' => new QuizEditorsResource($question),
        ], 201);
    }


    public function show(int $id)
    {
        try {
            $question = QuizEditor::with([
                'topics',
                'users'
            ])->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Question fetched successfully',
                'data' => new QuizEditorsResource($question),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function update(UpdateQuizEditorsQuestions $request, int $id)
    {
        try {
            $question = QuizEditor::findOrFail($id);
            $data = $request->validated();
            $question->update($data);
            $question->load([
                'topics',
                'users'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Question updated successfully',
                'data' => new QuizEditorsResource($question),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function update_image(Request $request, $id)
    {
        $request->validate([
            'file_path' => 'nullable|image|mimes:png|max:2048',
        ]);

        $question = QuizEditor::findOrFail($id);
        $questionId = $question->ques_id;

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');

            $imageSize = getimagesize($file);
            $maxWidth = 500;
            $maxHeight = 300;

            if ($imageSize[0] > $maxWidth || $imageSize[1] > $maxHeight) {
                return back()->withErrors(['file_path' => 'The image must not exceed 500x300 pixels.']);
            }

            $imageName = $questionId . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('quiz_images_uploads', $imageName, 'public');
            $question->filePath = $filePath;
            $question->save();
            return redirect()->route('quiz.editor.index')->with('success', 'Image updated successfully.');
        }

        return back()->withErrors(['file_path' => 'No image file uploaded.']);
    }



    public function destroy(int $id)
    {
        try {
            $question = QuizEditor::findOrFail($id);

            $question->delete();

            return response()->json([
                'status' => true,
                'message' => 'Question deleted successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function toggleStatus(int $id)
    {
        try {
            $question = QuizEditor::findOrFail($id);

            $question->status = $question->status === 'active'
                ? 'inactive'
                : 'active';

            $question->save();

            return response()->json([
                'status' => true,
                'message' => 'Question status updated successfully',
                'data' => [
                    'ques_id' => $question->ques_id,
                    'status' => $question->status,
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
