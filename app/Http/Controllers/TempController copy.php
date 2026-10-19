<?php

namespace App\Http\Controllers;

use App\Models\TempModel;
use App\Models\QuizSetModel;
use Illuminate\Http\Request;
use App\Models\QuestionModel;
use PHPUnit\Framework\isEmpty;
use App\Models\QuizEditorModel;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DBk\isEmpty;

class TempController extends Controller
{
    public function index(){
        $selected_questions = TempModel::with('quiztopics')->orderBy('created_at', 'desc')->get();

        return view('selected_questions')->with(compact('selected_questions'));
    }

    public function store($id) {
        // Find the question by its ID
        $question = QuizEditorModel::find($id);

        if (!$question) {
            return redirect()->back()->with('error', 'Question not found');
        }
  $existingRecord = TempModel::where('ques_id', $question->ques_id)
                                   ->where('topic_id', $question->topic_id)
                                   ->where('question', $question->question)
                                   ->first();

        if ($existingRecord) {
            return redirect()->route('quiz.editor.index')->with('error', 'Duplicate entry found!');
        }

        $data = new TempModel();
        $data->ques_id = $question->ques_id;
        $data->topic_id = $question->topic_id;
        $data->question = $question->question;
        $data->filePath = $question->filePath;
        $data->option_1 = $question->option_1;
        $data->option_2 = $question->option_2;
        $data->option_3 = $question->option_3;
        $data->option_4 = $question->option_4;
        $data->answer = $question->answer;

        $data->save();
        return redirect()->route('quiz.editor.index');
    }



    public function transfer(Request $request){
        $request->validate([
            'quiz_launch_date' => 'required|date|unique:quiz_set,quiz_launch_date',
        ]);
        try{
            $temp_questions = TempModel::all();
            if($temp_questions->isEmpty()){
                return redirect()->route('quiz-temp-index');
              }
            DB::beginTransaction();
            $quiz_set = new QuizSetModel;
            $quiz_set->quiz_launch_date = $request->quiz_launch_date;
            $quiz_set->save();
            $quiz_set_id = $quiz_set->quiz_set_id;


           foreach($temp_questions as $temp){
                $question = new QuestionModel();
                $question->quiz_set_id = $quiz_set_id;
                $question->ques_id = $temp->ques_id;
                $question->topic_id = $temp->topic_id;
                $question->question = $temp->question;
                $question->filePath = $temp->filePath;
                $question->option_1 = $temp->option_1;
                $question->option_2 = $temp->option_2;
                $question->option_3 = $temp->option_3;
                $question->option_4 = $temp->option_4;
                $question->answer = $temp->answer;
                $question->save();

                $editors = QuizEditorModel::find($temp->ques_id);
                $editors->status = 'disabled';
                $editors->save();
           }
           TempModel::truncate();
           return redirect()->route('quiz.set.index');
           DB::commit();
          }catch(\Exception){
            // DB::rollBack();
            // dd("Error");
            return redirect()->route('quiz.temp.index');
        }

    }



    public function destroy($id){

        $tempquestion = TempModel::find($id);
       $tempquestion->delete();

       return redirect()->route('quiz.temp.index');
    }





}
