<?php

namespace App\Http\Controllers;

use App\Models\QuizTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuizTopicController extends Controller
{
   
    public function index()
    {
       
            $topics = QuizTopic::all();

            return response()->json([
                'status' => true,
                'message' => 'Quiz topics fetched successfully',
                'data' => $topics,
            ]);
    }

    public function store(Request $request)
    {
       
            $data = $request->validate([
                'topic_name' => 'required|string|max:100',
            ]);

            $topic = QuizTopic::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Quiz topic created successfully',
                'data' => $topic,
            ], 201);

    }

    public function show(string $id)
    {
        try {
            $topic = QuizTopic::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Quiz topic fetched successfully',
                'data' => $topic,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz topic not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $topic = QuizTopic::findOrFail($id);

            $data = $request->validate([
                'topic_name' => 'required|string|max:255',
            ]);

            $topic->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Quiz topic updated successfully',
                'data' => $topic,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz topic not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(string $id)
    {
        try {
            $topic = QuizTopic::findOrFail($id);

            $topic->delete();

            return response()->json([
                'status' => true,
                'message' => 'Quiz topic deleted successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz topic not found',
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