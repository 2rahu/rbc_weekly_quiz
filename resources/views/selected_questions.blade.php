@extends('header')
@section('section')

<div class="container mx-auto bg-white p-6 shadow-md rounded-lg relative">
    <!-- Add Question Button -->
    {{-- <button id="add_question" class="absolute bg-red-700 text-white font-semibold px-6 py-2 rounded-full top-3 right-3 hover:bg-red-800 transition-all">
        Add Questions
    </button> --}}
 <div class="w-full h-10">
    <form action="{{ route('quiz.temp.transfer') }}" method="POST"  class="flex gap-4">
        @csrf
        <div class=" w-1/2 h-full p-1 bg-yellow-600 rounded flex justify-start items-center">
            <label for="quiz_launch_date" class="px-5 text-white">Select Date :</label>
            <input type="date" id="quiz_launch_date" name="quiz_launch_date" class="w-94 rounded-md" min="{{ date('Y-m-d') }}">

            @error('quiz_launch_date')
            <div id="error-message" class="alert alert-danger absolute top-0 left-[15%] bg-red-500 text-white px-3 py-1 rounded-md">{{ $message }}</div>
            <script>
                setTimeout(() => {
                    document.getElementById('error-message').classList.add('hidden');
                }, 3000);
                </script>

            @enderror
        </div>
        <button type="submit" class="bg-blue-600 px-3 rounded text-white text-xl shadow hover:bg-blue-800">Generate Quiz</button>
        </form>

        @if(session('error'))
        <div id="duplicate_date_update" class="alert alert-danger absolute top-0 left-[15%] bg-red-500 text-white px-3 py-1 rounded-md">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('duplicate_date_update').classList.add('hidden');
            }, 3000);
            </script>
    @endif

        {{-- @if($errors->any())
    <script>
        setTimeout(function() {
            document.getElementById('error-message').style.display = 'none';
        }, 3000); // 3000 milliseconds = 3 seconds
    </script> --}}
{{-- @endif --}}

 </div>

    <h2 class="text-2xl font-bold mb-4 text-gray-700 text-center">Selected Questions List</h2>

    <!-- Table with Scroll -->
    <div class="overflow-x-auto max-h-[450px]">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-purple-500 text-white">
                <tr>
                    <th class="p-3 border">ID</th>
                    <th class="p-3 border">Topic</th>
                    <th class="p-3 border">Question</th>
                    <th class="p-3 border">Image</th>
                    <th class="p-3 border">Option 1</th>
                    <th class="p-3 border">Option 2</th>
                    <th class="p-3 border">Option 3</th>
                    <th class="p-3 border">Option 4</th>
                    <th class="p-3 border">Answer</th>
                    <th class="">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($selected_questions as $question)
                <tr class="bg-gray-50 hover:bg-gray-200 transition">
                    <td class="p-3 border text-center">{{ $question->ques_id }}</td>
                    <td class="p-3 border"><textarea readonly=true class="text-center">{{ $question->quiztopics->topic_name }}</textarea></td>
                    <td class="p-3 border"><textarea readonly=true class="text-center">{{ $question->question }}</textarea></td>
                    <td class="p-3 border">
                        @if($question->filePath)
                            <img src="{{ asset('storage/' . $question->filePath) }}" width="70">
                        @else
                            <!-- You can leave it empty or show a placeholder -->
                            {{-- <span>No Image</span> --}}
                        @endif
                    </td>

                    <td class="p-3 border"><textarea readonly=true class="text-center">{{ $question->option_1 }}</textarea></td>
                    <td class="p-3 border"><textarea readonly=true class="text-center">{{ $question->option_2 }}</textarea></td>
                    <td class="p-3 border"><textarea readonly=true class="text-center">{{ $question->option_3 }}</textarea></td>
                    <td class="p-3 border"><textarea readonly=true class="text-center">{{ $question->option_4 }}</textarea></td>
                    <td class="p-3 border font-bold text-green-600">{{ $question->answer }}</td>
                    <td class="flex justify-center items-center py-5">
                        <a href="{{ route('quiz.temp.delete', $question->ques_id) }}" class="py-5">
                            <img src="{{ asset('assets/deletesymbol.png') }}" class="w-8 h-8">
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
