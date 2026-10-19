<?php

namespace App\Http\Controllers;

use App\Models\quizSet;
use App\Models\Questions;
use App\Models\QuizTopic;
use App\Models\QuizSetModel;
use Illuminate\Http\Request;
use App\Models\QuestionModel;
use App\Models\QuizTopicModel;
use App\Http\Controllers\Controller;

class QuizQuiestionsController extends Controller
{

    public function index(){
            $questions = Questions::with(['quiztopics','quizset'])->orderBy('created_at', 'desc')->paginate(20);
            $quiz_sets = quizSet::orderBy('created_at', 'desc')->get();
            $quiz_topics =QuizTopic::orderBy('created_at', 'desc')->get();
            return view('question_data')->with(compact('questions','quiz_sets','quiz_topics'));
    }

   public function store(Request $request){
        $request->validate([
            'quiz_set_id'=>'required|integer',
            'topic_id'=>'required|integer',
            'question'=>'required|string',
            'option_1'=>'required',
            'option_2'=>'required',
            'option_3'=>'required',
            'option_4'=>'required',
            'answer'=>'required',
        ]);

            if($request->hasFile('file_path')){
                $image = $request->file('file_path');
                $filePath = $image->store('quez_images_uploads', 'public');

            }

            $question = new Questions();
            $question->quiz_set_id = $request->quiz_set_id;
            $question->topic_id = $request->topic_id;
            $question->question = $request->question;
            $question->file_path = $filePath;
            $question->option_1 = $request->option_1;
            $question->option_2 = $request->option_2;
            $question->option_3 = $request->option_3;
            $question->option_4 = $request->option_4;
            $question->answer = $request->answer;
            $question->save();
            return redirect()->route('quiz.question.index');
    }


}
