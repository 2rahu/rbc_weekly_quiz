
@extends('header')
@section('section')

<!-- Form Container -->
<div class="w-full h-screen flex justify-center items-center overflow-hidden" id="show_form">

    <div class="bg-white p-4 rounded-lg shadow-xl w-full relative h-full flex justify-center items-center flex-col gap-2">

    <div class="bg-purple-500 text-2xl py-1 font-semibold w-full flex justify-between mrp-1 items-between  rounded-md text-white mb-4 text-center">
            <h1 class="ml-2">Create Question</h1>
            <a href="{{ route('quiz.editor.index') }}" class="mr-2">
             <img src="{{ asset('assets/back.png') }}" alt="Logo" class="h-10 z-[10]">
           </a>
    </div>


    @if (session('status'))
        <div class="mb-4 bg-green-500 text-white p-4 rounded-md">
            <p>{{ session('status') }}</p>
        </div>
    @endif

        @if ($errors->any())
        <div id="form_validation" class="mb-4 bg-red-500 text-white p-3 rounded-md text-center absolute top-2 right-[12%]">
            <p class="font-semibold">Invalid format or missing fields. Please check your inputs and try again.</p>
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('form_validation').classList.add('hidden');
            }, 3000);

            </script>

    @endif
        <!-- Form -->
        <form class="w-5/6 h-full bg-purple-200 rounded-md flex p-5 justify-center items-center flex-col gap-1" action="{{ route('quiz.editor.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <!-- Topic -->
            <div class="w-full">
                <label for="topic_id" class="block text-lg font-medium text-gray-700">Topic</label>
                <select id="topic_id" name="topic_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" required>
                    <option value="" disabled selected>-- Select Topic --</option>
                    @foreach ($quiz_topics as $topic)
                        <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Question -->
            <div class="w-full">
                <label for="question" class="block text-lg font-medium text-gray-700">Question</label>
                <textarea id="question" name="question" rows="2" placeholder="Enter the question" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" required></textarea>
            </div>

            <!-- Image Upload -->
            {{-- <div>
                <label for="file_path" class="block text-lg font-medium text-gray-700">Upload Image (Optional)</label>
                <input type="file" id="file_path" name="file_path" class="w-full py-1 px-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500">

            </div> --}}

            <!-- Options (Grid Layout) -->
            <div class="w-full">
                <label class="block text-lg font-medium text-gray-700">Options</label>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="option_1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 1" required>
                    <input type="text" name="option_2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 2" required>
                    <input type="text" name="option_3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 3" required>
                    <input type="text" name="option_4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Option 4" required>
                </div>
            </div>

            <!-- Correct Answer -->
            <div class="w-full">
                <label for="answer" class="block text-lg font-medium text-gray-700">Correct Answer</label>
                <input type="text" id="answer" name="answer" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" placeholder="Enter the correct answer" required>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-4">
                <button type="submit" class="py-3 px-8 bg-purple-500 text-white text-lg font-semibold rounded-md hover:bg-purple-600 transition duration-200">Submit Question</button>
            </div>
        </form>

    </div>
    @if (session('error'))
    <div class="mb-4 bg-red-500 text-white p-4 rounded-md absolute top-0 right-0 z-[10]">
        <p>{{ session('error') }}</p>
    </div>
@endif
</div>



    @endsection
