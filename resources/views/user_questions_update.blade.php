<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editors Questions Update</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-purple-700 flex justify-center items-center h-screen p-2 overflow-hidden">
    <a href="{{ route('quiz.useradmin.index') }}" class="absolute top-2 left-2">
        <img src="{{ asset('assets/back.png') }}" alt="Logo" class="h-12 w-auto ml-4">
    </a>

    <!-- Form Container -->
    <div class="bg-white p-3 md:p-8 rounded-lg shadow-lg w-full h-auto max-w-3xl relative overflow-hidden">

        <h1 class="text-3xl font-bold text-gray-700 mb-4 text-center">Edit Question</h1>

        <form class="grid grid-cols-1 md:grid-cols-2 gap-2" action="{{ route('quiz.useradmin.update', ['id'=>$editors_questions->ques_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Topic -->
            <div class="col-span-2">
                <label for="topic_id" class="block text-lg font-semibold text-gray-700">Topic</label>
                <select id="topic_id" name="topic_id" class="w-full px-4 py-1 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" required>
                    <option value="{{ $editors_questions->topic_id }}" selected>{{ $editors_questions->quiztopics->topic_name }}</option>
                    @foreach ($topics as $topic)
                        @if ($topic->topic_id !== $editors_questions->topic_id)
                            <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <!-- Question -->
            <div class="col-span-2">
                <label for="question" class="block text-lg font-semibold text-gray-700">Question</label>
                <input type="text" id="question" value="{{ $editors_questions->question }}" name="question" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter the question">
            </div>

            <!-- Options -->
            <div class="col-span-2">
                <label class="block text-lg font-semibold text-gray-700">Options</label>
            </div>
            <div><input type="text" value="{{ $editors_questions->option_1 }}" name="option_1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 1" required></div>
            <div><input type="text" value="{{ $editors_questions->option_2 }}" name="option_2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 2" required></div>
            <div><input type="text" value="{{ $editors_questions->option_3 }}" name="option_3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 3" required></div>
            <div><input type="text" value="{{ $editors_questions->option_4 }}" name="option_4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 4" required></div>

            <!-- Correct Answer -->
            <div class="col-span-2">
                <label for="answer" class="block text-lg font-semibold text-gray-700">Correct Answer</label>
                <input type="text" id="answer" value="{{ $editors_questions->answer }}" name="answer" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter the correct answer" required>
            </div>

            <!-- Submit Button -->
            <div class="col-span-2 mt-6 flex justify-center">
                <button type="submit" class="py-2 px-8 bg-orange-500 text-white text-lg font-semibold rounded-md hover:bg-orange-600 transition">
                    Submit Question
                </button>
            </div>
        </form>



<!-- Display Validation Errors -->
@if ($errors->any())
    <div id="error-alert" class="alert alert-danger absolute bg-red-500 absolute top-1 right-[35%] text-white rounded p-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    <script>

        setTimeout(() => {
                document.getElementById('error-alert').classList.add('hidden');
        }, 3000);

    </script>
@endif


@if (session('success'))
        <div id="custom-alert-success" class="fixed top-5 right-[45%] p-4 bg-green-500 text-white rounded shadow-md z-[10]">
            {{ session('success') }}
        </div>

<script>
    setTimeout(function() {
        document.getElementById('custom-alert-success')?.remove();
        document.getElementById('topic_modal')?.classList.add('hidden'); // Form hide kare success pe
    }, 3000);
</script>
@endif


</body>

</html>
