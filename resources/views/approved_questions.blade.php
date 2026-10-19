<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" class="rounded-md">
    <title>All Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-700 text-white flex justify-center items-center min-h-screen p-6 overflow-hidden">
    <img src="{{ asset('assets/logo.png') }}" alt="Admin Logo" class="w-[70px] h-[50px] absolute top-1 left-1 rounded-md shadow-md">
    <a href="{{ route('quiz.useradmin.index') }}" class="absolute top-2 left-2 ">
        <img src="{{ asset('assets/back.png') }}" alt="Logo" class="h-12 w-auto ml-[5rem]">
    </a>
    <div class="w-full">
        <h2 class="text-3xl font-bold mb-4 text-right">Approved Questions</h2>

        <!-- Table Container -->
        <div class="w-full h-[520px] overflow-y-auto border border-gray-300 rounded-lg shadow-lg bg-white">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-purple-700 text-white sticky top-0">
                    <tr>
                        <th class="p-3 border">Sr No</th>
                        <th class="p-3 border">Topic</th>
                        <th class="p-3 border">Question</th>
                        <th class="p-3 border">Image</th>
                        <th class="p-3 border">Option 1</th>
                        <th class="p-3 border">Option 2</th>
                        <th class="p-3 border">Option 3</th>
                        <th class="p-3 border">Option 4</th>
                        <th class="p-3 border">Answer</th>
                        <th class="p-3 border">User</th>

                    </tr>
                </thead>
                <tbody>
                    <!-- Example data loop -->
                    @foreach($editors as $question)
                    <tr class="border-t transition duration-300 ease-in-out
                    {{ $question->status === 'disabled' ? 'bg-green-300 text-black' : 'bg-white hover:bg-gray-100' }}">

                        <td class="p-3 text-center border">{{ $loop->iteration }}</td>
                        <td class="p-3 text-center border text-gray-800">{{ $question->quiztopics->topic_name }}</td>
                        <td class="p-3 text-center border text-gray-800">{{ $question->question }}</td>
                        <td class="p-3 text-center flex justify-center">
                            @if (!empty($question->filePath))  <!-- Agar image available hai -->
                                <img src="{{ asset('storage/' . $question->filePath) }}" width="60"
                                    class="cursor-pointer  transition-transform hover:scale-105"
                                    onclick="openModal('{{ asset('storage/' . $question->filePath) }}')">

                                @if ($question->status !== 'disabled')
                                    <a href="{{ route('quiz.useradmin.edit.image', ['id' => $question->ques_id]) }}"
                                        class="px-4 py-1 bg-red-600 rounded text-white text-sm ml-2 hover:bg-red-700">Edit</a>
                                @endif
                            @endif
                        </td>
                        <td class="p-3 text-center border text-gray-800">{{ $question->option_1 }}</td>
                        <td class="p-3 text-center border text-gray-800">{{ $question->option_2 }}</td>
                        <td class="p-3 text-center border text-gray-800">{{ $question->option_3 }}</td>
                        <td class="p-3 text-center border text-gray-800">{{ $question->option_4 }}</td>
                        <td class="p-3 text-center border font-bold text-green-600">{{ $question->answer }}</td>
                        <td class="p-3 text-center border font-bold text-green-600">{{ $question->userlist->username }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
