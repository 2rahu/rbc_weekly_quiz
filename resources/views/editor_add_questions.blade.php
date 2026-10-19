@extends('header')
@section('section')

<div class="container mx-auto bg-white p-6 shadow-md rounded-lg relative">
    <!-- Add Question Button -->
    <button id="add_question" class="absolute bg-red-700 text-white font-semibold px-6 py-2 rounded-full top-3 right-3 hover:bg-red-800 transition-all">
        Add Questions
    </button>

    <h2 class="text-2xl font-bold mb-4 text-gray-700 text-center">Editors Questions List</h2>

    <!-- Table -->
    <div class="w-full max-h-[550px] overflow-y-auto overflow-x-auto border border-gray-300 rounded-lg">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-700 text-white sticky top-0">
                <tr>
                    <th class="p-3 border">Id</th>
                    <th class="p-3 border">Topic</th>
                    <th class="p-3 border">Question</th>
                    <th class="p-3 border">Image</th>
                    <th class="p-3 border">Option 1</th>
                    <th class="p-3 border">Option 2</th>
                    <th class="p-3 border">Option 3</th>
                    <th class="p-3 border">Option 4</th>
                    <th class="p-3 border">Answer</th>
                    <th class="p-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($editors as $question)
                <tr class="bg-gray-50 hover:bg-gray-200 transition">
                    <td class="p-3 border text-center">
                        {{ $question->ques_id }}
                        <a href="{{ route('quiz.temp.store', ['id'=>$question->ques_id]) }}" class="m-1 bg-yellow-500 px-2 py-1 rounded-md">Add</a>
                    </td>
                    <td class="p-3 border">{{ $question->topic_id }}</td>
                    <td class="p-3 border">{{ $question->question }}</td>
                    <td class="p-3 border"><img src="{{ asset('storage/' . $question->filePath) }}" width="70">
                    <a href="{{ route('quiz.editor.edit.image', ['id'=>$question->ques_id]) }}" class="px-4 bg-red-600 rounded text-white">Edit</a>
                    </td>
                    <td class="p-3 border">{{ $question->option_1 }}</td>
                    <td class="p-3 border">{{ $question->option_2 }}</td>
                    <td class="p-3 border">{{ $question->option_3 }}</td>
                    <td class="p-3 border">{{ $question->option_4 }}</td>
                    <td class="p-3 border font-bold text-green-600">{{ $question->answer }}</td>
                    <td class="p-3 border text-center">
                        <a href="{{ route('quiz.editor.edit', $question->ques_id) }}" class="px-4 bg-blue-500 text-white rounded hover:bg-blue-700 transition">Edit</a>
                        <form action="{{ route('quiz.editor.delete', $question->ques_id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 bg-red-500 text-white rounded hover:bg-red-700 transition">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Form Container -->
<div class="fixed inset-0 flex justify-center items-center bg-gray-900 bg-opacity-50 hidden" id="show_form">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl relative">
        <button id="close_form" type="button" class="absolute top-4 right-4 bg-red-500 py-1 px-3 rounded-full text-white hover:bg-gray-700">X</button>

        <h1 class="text-3xl font-bold text-gray-700 mb-6 text-center">Create Question</h1>

        <!-- Form -->
        <form class="grid grid-cols-1 md:grid-cols-2 gap-4" action="{{ route('quiz.editor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Topic -->
            <div class="col-span-2">
                <label for="topic_id" class="block text-lg font-semibold text-gray-700">Topic</label>
                <select id="topic_id" name="topic_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" required>
                    <option value="" disabled selected>Select a topic</option>
                    @foreach ($quiz_topics as $topic)
                    <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Question -->
            <div class="col-span-2">
                <label for="question" class="block text-lg font-semibold text-gray-700">Question</label>
                <input type="text" id="question" name="question" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter the question">
            </div>

            <!-- Image Upload -->
            <div class="col-span-2">
                <label for="file_path" class="block text-lg font-semibold text-gray-700">Upload Image (Optional)</label>
                <input type="file" id="file_path" name="file_path" class="w-full py-2 px-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500">
            </div>

            <!-- Options -->
            <div class="col-span-2">
                <label class="block text-lg font-semibold text-gray-700">Options</label>
            </div>
            <div><input type="text" name="option_1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 1" required></div>
            <div><input type="text" name="option_2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 2" required></div>
            <div><input type="text" name="option_3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 3" required></div>
            <div><input type="text" name="option_4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 4" required></div>

            <!-- Correct Answer -->
            <div class="col-span-2">
                <label for="answer" class="block text-lg font-semibold text-gray-700">Correct Answer</label>
                <input type="text" id="answer" name="answer" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter the correct answer" required>
            </div>

            <!-- Submit Button -->
            <div class="col-span-2 mt-6 flex justify-center">
                <button type="submit" class="py-3 px-8 bg-orange-500 text-white text-lg font-semibold rounded-md hover:bg-orange-600 transition">
                    Submit Question
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.getElementById('add_question').addEventListener('click', function() {
        document.getElementById('show_form').classList.remove('hidden');
    });

    document.getElementById('close_form').addEventListener('click', function() {
        document.getElementById('show_form').classList.add('hidden');
    });
</script>

@endsection
