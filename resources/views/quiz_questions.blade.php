<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Form</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CDN -->
</head>
<body class="bg-[url({{ asset('./assets/bg4.png') }})] bg-cover py-10 px-4 overflow-hidden">
    {{-- <a href="{{ route('backPage') }}" class="w-[100px] h-[50px] bg-white text-black rounded absolute top-0 right-0 flex justify-center items-center">Back</a> --}}

    <div class="max-w-4xl mx-auto bg-white p-4 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-left mb-2">Create Question</h1>

        <form action="{{ route('quiz.question.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Quiz Code Field -->
                <div>
                    <label for="quiz_set_id" class="block text-lg font-semibold text-gray-700">Quiz Code</label>
                    <select id="quiz_set_id" name="quiz_set_id" class="w-full px-4 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                        <option value="" disabled selected>Select a quizCode</option>
                        @foreach ($quiz_sets as $sets)
                            <option value="{{ $sets->quiz_set_id }}">{{ $sets->quiz_launch_date }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Topic Field -->
                <div>
                    <label for="topic_id" class="block text-lg font-semibold text-gray-700">Topic</label>
                    <select id="topic_id" name="topic_id" class="w-full px-4 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                        <option value="" disabled selected>Select a topic</option>
                        @foreach ($quiz_topics as $topic)
                            <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Question Field -->
            <div class="mb-4">
                <label for="question" class="block text-lg font-semibold text-gray-700">Question</label>
                <input type="text" id="question" name="question" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Enter the question">
            </div>

            <!-- Image Upload Field -->
            <div class="mb-4">
                <label for="file_path" class="block text-lg font-semibold text-gray-700">Upload Image (Optional)</label>
                <input type="file" id="file_path" name="file_path" class="w-full text-gray-700 py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <!-- Options Fields -->
            <div class="mb-4 space-y-2">
                <label class="block text-lg font-semibold text-gray-700">Options</label>
                <div class="flex items-center">
                    <input type="text" name="option_1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Option 1" required>
                </div>
                <div class="flex items-center">
                    <input type="text" name="option_2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Option 2" required>
                </div>
                <div class="flex items-center">
                    <input type="text" name="option_3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Option 3" required>
                </div>
                <div class="flex items-center">
                    <input type="text" name="option_4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Option 4" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="answer" class="block text-lg font-semibold text-gray-700">Correct Answer</label>
                <input type="text" id="answer" name="answer" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Enter the correct answer" required>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 px-6 bg-orange-500 text-white font-semibold rounded-md hover:bg-purple-600 transition duration-200">Submit Question</button>
            </div>
        </form>
    </div>
</body>
</html>
