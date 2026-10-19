<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Form</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CDN -->
</head>
<body class="bg-[url({{ asset('./assets/bg4.png') }})] bg-cover py-10 px-4 overflow-hidden">
    {{-- <a href="" class="w-[100px] h-[50px] bg-white text-black rounded absolute">Create Quiz</a> --}}

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-left mb-2">Create Question</h1>

        <form action="{{ edit_submit }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-2  absolute top-[8%] right-[25%] flex flex-row w-1/4 gap-5">
                <label for="quizCode" class="block text-lg font-semibold text-gray-700">Quiz Code</label>
                <input type="text" id="quizCode" value="{{ $quizCode->quizCode }}" name="quizCode" class="w-1/2 px-4 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Enter the topic" required>
            </div>
            <!-- Topic Field -->
            <div class="mb-4">
                <label for="topic" class="block text-lg font-semibold text-gray-700">Topic</label>
                <input type="text" id="topic" value="{{ $quizCode->quizCode }}" name="topic" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Enter the topic" required>
            </div>

            <!-- Question Field -->
            <div class="mb-4">
                <label for="question" class="block text-lg font-semibold text-gray-700">Question</label>
                <input type="text" id="question" value="{{ $quizCode->Question }}" name="question" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Enter the question" required>
            </div>

            <!-- Image Upload Field -->
            <div class="mb-4">
                <label for="file" class="block text-lg font-semibold text-gray-700">Upload Image (Optional)</label>
                <input type="file" id="file" value="{{ $quizCode->filePath }}" name="file" class="w-full text-gray-700 py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <!-- Options Fields -->
            <div class="mb-4 space-y-2">
                <label class="block text-lg font-semibold text-gray-700">Options</label>
                <div class="flex items-center">

                    <input type="text" id="option1_text" value="{{ $quizCode->Option1 }}" name="option1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Option 1" required>
                </div>
                <div class="flex items-center">

                    <input type="text" id="option2_text" value="{{ $quizCode->Option2 }}" name="option2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Option 2" required>
                </div>
                <div class="flex items-center">

                    <input type="text" id="option3_text" value="{{ $quizCode->Option3}}" name="option3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Option 3" required>
                </div>
                <div class="flex items-center">

                    <input type="text" id="option4_text" value="{{ $quizCode->Option4}}" name="option4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Option 4" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="correct" class="block text-lg font-semibold text-gray-700">Correct Answer</label>
                <input type="text" id="correct" value="{{ $quizCode->Correct }}" name="correct" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Enter the question" required>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 px-6 bg-orange-500 text-white font-semibold rounded-md hover:bg-purple-600 transition duration-200">Submit Question</button>
            </div>
        </form>
    </div>

</body>
</html>





