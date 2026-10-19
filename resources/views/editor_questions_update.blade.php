@extends('header')
@section('section')

<div class="container mx-auto border-gray-300  p-8 w-5/6 h-full">
    <!-- Close Button -->
    <a href="{{ route('quiz.editor.index') }}" id="close_form" type="button" class="absolute top-4 right-4 bg-red-500 py-1 px-3 text-xl rounded-full text-white hover:bg-gray-700">
        &times;
    </a>

    <!-- Form Title -->


    <!-- Form -->
    <form action="{{ route('quiz.editor.update', ['id'=>$editors_questions->ques_id]) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-md w-full h-full flex justify-center items-center flex-col gap-4">
        @csrf
        <h1 class="text-2xl font-bold text-gray-700 text-center">Edit Question</h1>

        <!-- Topic -->
        <div class="w-4/5">
            <label for="topic_id" class="block text-md font-semibold text-gray-700 mb-1">Topic</label>
            <select id="topic_id" name="topic_id" class="w-full px-4 py-3 border rounded-md focus:ring-2 focus:ring-orange-500" required>
                <option value="{{ $editors_questions->topic_id }}" selected>{{ $editors_questions->quiztopics->topic_name }}</option>
                @foreach ($topics as $topic)
                    @if ($topic->topic_id !== $editors_questions->topic_id)
                        <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <!-- Question -->
        <div class="w-4/5">
            <label for="question" class="block text-md font-semibold text-gray-700 mb-1">Question</label>
            <textarea id="question" name="question" required placeholder="Enter Question" class="py-3 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500">{{ $editors_questions->question }}</textarea>
        </div>


        <!-- Options -->
        <div class="mb-4 w-4/5">
            <label class="block text-md font-semibold text-gray-700">Options</label>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" value="{{ $editors_questions->option_1 }}" name="option_1" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 1" required>
                <input type="text" value="{{ $editors_questions->option_2 }}" name="option_2" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 2" required>
                <input type="text" value="{{ $editors_questions->option_3 }}" name="option_3" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 3" required>
                <input type="text" value="{{ $editors_questions->option_4 }}" name="option_4" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 4" required>
            </div>
        </div>

        <!-- Correct Answer -->
        <div class="mb-6 w-4/5">
            <label for="answer" class="block text-md font-semibold text-gray-700 mb-1">Correct Answer</label>
            <input type="text" id="answer" value="{{ $editors_questions->answer }}" name="answer" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter the correct answer" required>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center">
            <button type="submit" class="py-3 px-8 bg-orange-500 text-white text-md font-semibold rounded-md hover:bg-orange-600 transition">
                Submit Question
            </button>
        </div>
    </form>
</div>

@endsection
