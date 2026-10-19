<?php

namespace App\Http\Controllers;

use App\Models\QuizTopic;
use App\Models\QuizEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserAdminController extends Controller
{
    public function index(){
        $questions = QuizEditor::with('quiztopics', 'userlist')
        ->where('status', 'active')->where('login_id', session()->get('login_id'))
        ->orderBy('created_at', 'desc')->get();
        $quiz_topics = QuizTopic::orderBy('created_at', 'desc')->get();
        $username =  session()->get('username');
        return view('user')->with(compact('questions', 'quiz_topics', 'username'));
    }

    public function approved()
    {
        $editors = QuizEditor::with('quiztopics', 'userlist')
                    ->where('status', 'disabled')
                    ->orderBy('created_at', 'desc')
                    ->get();

        $quiz_topics = QuizTopic::orderBy('created_at', 'desc')->get();

        return view('approved_questions')->with(compact('editors', 'quiz_topics'));
    }



    public function form_show(){
        $quiz_topics = QuizTopic::all();
        return view('user_add_question')->with(compact('quiz_topics'));
    }


    public function store(Request $request)
{
    // Validation for both text and file fields
    $request->validate([
        'topic_id'  => 'required|exists:quiz_topics,topic_id',
        'question'  => 'required|string|filled',
        'option_1'  => 'required|string|filled',
        'option_2'  => 'required|string|filled',
        'option_3'  => 'required|string|filled',
        'option_4'  => 'required|string|filled',
        'answer'    => 'required|string|filled',
        'file_path' => 'nullable|image|mimes:png|max:2048',
    ]);

    // Clean and sanitize input
    $request->merge([
        'topic_id'  => trim($request->topic_id),
        'question'  => preg_replace('/\s+/', ' ', trim($request->question)),
        'option_1'  => preg_replace('/\s+/', ' ', trim($request->option_1)),
        'option_2'  => preg_replace('/\s+/', ' ', trim($request->option_2)),
        'option_3'  => preg_replace('/\s+/', ' ', trim($request->option_3)),
        'option_4'  => preg_replace('/\s+/', ' ', trim($request->option_4)),
        'answer'    => preg_replace('/\s+/', ' ', trim($request->answer)),
    ]);

    try {
        DB::beginTransaction();

        // Create a new quiz question
        $question = new QuizEditor();
        $question->topic_id = $request->topic_id;
        $question->question = $request->question;
        $question->option_1 = $request->option_1;
        $question->option_2 = $request->option_2;
        $question->option_3 = $request->option_3;
        $question->option_4 = $request->option_4;
        $question->answer = $request->answer;
        $question->login_id = session()->get('login_id');
        $question->save();

        DB::commit();

        return redirect()->route('quiz.useradmin.index')->with('status', 'Question created successfully!');

    } catch (\Exception $e) {
        // Rollback on error and show message
        DB::rollBack();
        session()->flash('error', 'An error occurred while saving the question. Please try again.');
        return redirect()->back()->withInput();
    }
}


    public function store_topic(Request $request) {
            $validate = $request->validate([
                'topic_name' => ['required', 'string', 'regex:/^[a-zA-Z]+( [a-zA-Z]+)*$/'],
            ], [
                'topic_name.regex' => 'Only alphabets and single spaces are allowed. No double spaces or numbers.',
                'topic_name.required' => 'The topic_name field is required.',
            ]);
            $topic_name = preg_replace('/\s+/', ' ', trim($validate['topic_name']));
            $existingTopic = QuizTopic::where('topic_name', $topic_name)->first();
            if ($existingTopic) {
                return redirect()->route('quiz.useradmin.index')->with('error', 'This topic already exists!');
            }
            QuizTopic::create([
                'topic_name' => strtoupper(trim($request->topic_name))
            ]);
            return redirect()->route('quiz.useradmin.index')->with('success', 'Topic created successfully!');
        }




    public function edit($id){
        $editors_questions = QuizEditor::find($id);
        $editors_questions->with('quiztopics');
        $topics = QuizTopic::all();
        // dd($editors_questions->toArray());
        return view('user_questions_update')->with(compact('editors_questions', 'topics'));
    }



    public function update(Request $request, $id)
    {
        // Find the question by ID
        $question = QuizEditor::find($id);

        // Validate request data
        $request->validate([
            'question'  => 'required|string|filled',
            'option_1'  => 'required|string|filled',
            'option_2'  => 'required|string|filled',
            'option_3'  => 'required|string|filled',
            'option_4'  => 'required|string|filled',
            'answer'    => 'required|string|filled',
        ]);

        // Merge data (optional, but useful to clean input before saving)
        $request->merge([
            'topic_id'  => trim($request->topic_id),
            'question'  => preg_replace('/\s+/', ' ', trim($request->question)),
            'option_1'  => preg_replace('/\s+/', ' ', trim($request->option_1)),
            'option_2'  => preg_replace('/\s+/', ' ', trim($request->option_2)),
            'option_3'  => preg_replace('/\s+/', ' ', trim($request->option_3)),
            'option_4'  => preg_replace('/\s+/', ' ', trim($request->option_4)),
            'answer'    => preg_replace('/\s+/', ' ', trim($request->answer)),
        ]);

        // Update the question
        $question->topic_id = $request->topic_id;
        $question->question = $request->question;
        $question->option_1 = $request->option_1;
        $question->option_2 = $request->option_2;
        $question->option_3 = $request->option_3;
        $question->option_4 = $request->option_4;
        $question->answer = $request->answer;
        $question->save();

        // Redirect back to the index page after successful update
        session()->flash('success', 'Data Update Successfully..');
        return redirect()->route('quiz.useradmin.index');
    }





    public function edit_image($id){
        $image_update = QuizEditor::find($id);
        // dd($image_update);

        return view('editor_question_image_update')->with(compact('image_update'));
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
                // return redirect()->route('quiz.useradmin.index')->withErrors(['file_path' => 'The image must not exceed 500x300 pixels.']);
                return redirect()->route('quiz.useradmin.index')->with('error', 'The image must not exceed 500x300 pixels.');
            }

            $imageName = $questionId . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('quiz_images_uploads', $imageName, 'public');
            $question->filePath = $filePath;
            $question->save();
            return redirect()->route('quiz.useradmin.index')->with('success', 'Image updated successfully.');
        }

    }



    public function destroy_image($id)
    {
        $file = QuizEditor::find($id);

        if ($file) {
            if (Storage::disk('public')->exists($file->filePath)) {
                Storage::disk('public')->delete($file->filePath);
            } else {
                return redirect()->route('quiz.useradmin.index')->with('error', 'File not found in storage!');
            }
            $file->filePath = null;
            $file->save();
            return redirect()->route('quiz.useradmin.index')->with('success', 'Image successfully deleted from storage and file path removed from database!');
        } else {
            return redirect()->route('quiz.useradmin.index')->with('error', 'File not found in database!');
        }
    }




    public function destroy($id){
        $editors = QuizEditor::find($id);
        $editors->delete();
        return redirect()->route('quiz.useradmin.index');
    }



}
