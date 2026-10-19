<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" class="rounded-md">
    <title>Online Quiz Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom purple scroll */
        /* .w-full {
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #6a0dad #e0e0e0;
        } */

        .w-full::-webkit-scrollbar {
            width: 5px;
        }

        .w-full::-webkit-scrollbar-track {
            background: #daa2fc;
        }

        .w-full::-webkit-scrollbar-thumb {
            background-color: #af59ec;
            border-radius: 10px;
        }

        .w-full::-webkit-scrollbar-thumb:hover {
            background-color: #4b007d;
        }
    </style>
</head>


<body class="">

    <div class="w-full h-full mx-auto shadow-md rounded-lg flex flex-col">

        <div class="w-full flex justify-between bg-purple-500 items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-12 w-auto ml-2 rounded-md shadow-md">
            <div class="flex items-center gap-3 mr-4">
                <button id="add_topic"
                    class="bg-red-700 text-white font-semibold px-6 py-2 rounded-full hover:bg-red-800 transition-all">
                    Add Topic
                </button>
                <!-- Add Question Button -->
                <a href="{{ route('quiz.form.show') }}" id="add_question"
                    class="bg-green-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-green-800 transition-all">
                    Add Question
                </a>
                <button id="" class="bg-green-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-green-800 transition-all">
                    <a href="{{ route('quiz.useradmin.approved') }}">Approved Question</a>
                </button>
                <div class="flex justify-end items-end flex-col mb-2">
                    <h1 class="text-white font-semibold text-sm mr-2">User Name : {{ $username }}</h1>
                    <!-- Log Out Button -->
                    {{-- <button id="logout_button"> --}}
                        <a href="{{ route('login.index') }}" class="w-8 h-8"><img src="{{ asset('assets/logout.png') }}" alt="Logo"></a>
                    {{-- </button> --}}
                </div>

            </div>
        </div>

<!--- ************************************************** --->
    <!-- Addd Topic ----->
<!--- ************************************************** --->




<!--- ************************************************** --->
    <!-- Addd Topic ----->
<!--- ************************************************** --->




<!--- ************************************************** --->
    <!-- Show All Questions ----->
<!--- ************************************************** --->

        {{-- <h2 class="text-xl font-bold mb-4 ml-[8%] text-white text-left">All Questions</h2> --}}

        <!-- Table -->
<div class="w-full h-[90vh] p-1 overflow-y-auto border border-gray-300 rounded-lg">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-300 text-gray-700 sticky top-0">
                    <tr>
                        <th class="p-1 border text-sm">Sr No</th>
                        <th class="p-1 border text-sm">Topic</th>
                        <th class="p-1 border text-sm">Question</th>
                        <th class="p-1 px-8 border text-sm">Image</th>
                        <th class="p-1 border text-sm">Option 1</th>
                        <th class="p-1 border text-sm">Option 2</th>
                        <th class="p-1 border text-sm">Option 3</th>
                        <th class="p-1 border text-sm">Option 4</th>
                        <th class="p-1 border text-sm">Answer</th>
                        <th class="p-1 border text-sm">User</th>
                        <th class="p-1 border text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data loop -->
                    @foreach($questions as $question)
                    <tr class="border-t transition
                    {{ $question->status === 'disabled' ? 'bg-green-300 text-black' : 'bg-white' }}">

                    <td class="p-1 text-sm text-center border">{{ $loop->iteration }}</td>
                        <td class="p-1 text-sm text-center border"><textarea readonly=true class="text-center">{{ $question->quiztopics->topic_name }}</textarea></td>
                        <td class="p-1 text-sm text-center border"><textarea readonly=true class="text-center">{{ $question->question }}</textarea></td>
                        <td class="text-sm flex justify-center items-center flex-col gap-1">
                            @if(!empty($question->filePath))
                            <a href="{{ route('quiz.useradmin.delete.image', $question->ques_id) }}" class=""><img
                                src="{{ asset('assets/deletesymbol.png') }}" class="w-5 h-5"></a>
                                <img src="{{ asset('storage/' . $question->filePath) }}" width="70" class="cursor-pointer rounded-md shadow-md transition-transform hover:scale-105"
                                    onclick="openModal('{{ asset('storage/' . $question->filePath) }}')">
                                <form action="{{ route('quiz.useradmin.update.image', ['id'=>$question->ques_id]) }}" method="POST" enctype="multipart/form-data" id="image_upload_form_{{ $question->ques_id }}" class="image_upload_form text-md w-15 flex flex-col justify-center items-center">
                                    @csrf
                                    <input type="file" name="file_path" alt="" class="text-[7px] w-full p-1" id="image_input_{{ $question->ques_id }}" onchange="enableUploadButton({{ $question->ques_id }})">
                                    <button type="submit" id="upload_button_{{ $question->ques_id }}" class="disabled:opacity-50" disabled onclick="return false;">
                                        <img src="{{ asset('assets/file-upload.png') }}" class="w-6 h-6">
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('quiz.useradmin.update.image', ['id'=>$question->ques_id]) }}" method="POST" enctype="multipart/form-data" id="image_upload_form_{{ $question->ques_id }}" class="image_upload_form text-md w-15 flex flex-col justify-center items-center">
                                    @csrf
                                    <input type="file" name="file_path" alt="" class="text-[7px] w-full p-1" id="image_input_{{ $question->ques_id }}" onchange="enableUploadButton({{ $question->ques_id }})">
                                    <button type="submit" id="upload_button_{{ $question->ques_id }}" class="disabled:opacity-50" disabled onclick="return false;">
                                        <img src="{{ asset('assets/file-upload.png') }}" class="w-6 h-6">
                                    </button>
                                </form>
                            @endif

                        </td>

                        <td class="p-1 text-sm text-center border"><textarea readonly=true class="text-center">{{ $question->option_1 }}</textarea></td>
                        <td class="p-1 text-sm text-center border"><textarea readonly=true class="text-center">{{ $question->option_2 }}</textarea></td>
                        <td class="p-1 text-sm text-center border"><textarea readonly=true class="text-center">{{ $question->option_3 }}</textarea></td>
                        <td class="p-1 text-sm text-center border"><textarea readonly=true class="text-center">{{ $question->option_4 }}</textarea></td>
                        <td class="p-1 text-sm text-center border font-bold text-green-600"><textarea readonly=true class="text-center">{{ $question->answer }}</textarea></td>
                        <td class="p-1 text-sm text-center border font-bold text-green-600"><textarea readonly=true class="text-center">{{ $question->userlist->username }}</textarea></td>
                        <td class="p-1 flex justify-center items-center gap-2 flex-col" >
                            @if ($question->status !== 'disabled')
                                <!-- Only show if status is active -->
                                <a href="{{ route('quiz.useradmin.edit', $question->ques_id) }}"><img
                                    src="{{ asset('assets/editsymbol.png') }}" class="w-8 h-8"> {{ $question->status === 'disabled' ? 'disabled' : '' }}</a>
                            <a href="{{ route('quiz.useradmin.delete', $question->ques_id) }}" class=""><img
                                    src="{{ asset('assets/deletesymbol.png') }}" class="w-8 h-8"></a>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</div>

<!--- ************************************************** --->
    <!-- Show All Questions ----->
<!--- ************************************************** --->





<div id="topic_modal" class="topic_add w-full hidden h-full fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-[10]">
    {{-- @if ($errors->any()) hidden @else block @endif"> --}}

    <form action="{{ route('quiz.useradmin.store.topic') }}" method="POST"
          class="bg-white p-6 rounded-md shadow-md w-full max-w-sm flex justify-end items-end flex-col gap-4">

        @csrf

        <button id="close_topic" type="button" class="close_topic w-1/4 rounded-md shadow-md px-5 py-2 bg-red-500 hover:bg-red-600 text-white">
            Close
        </button>

        <label for="topic_name" class="w-full text-lg font-semibold text-gray-700">Add Topic:</label>
        <input type="text" id="topic_name" name="topic_name" placeholder="Enter topic name"
               class="w-full py-2 px-3 text-black border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500" required>


        @if ($errors->has('topic_name'))
            <p class="text-red-600 text-sm mt-1">{{ $errors->first('topic_name') }}</p>
        @endif



        <button type="submit"
                class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 rounded-md transition w-full">
            Add Topic
        </button>
    </form>
</div>
        @if(session('error'))
        <div id="topic_error_id" class="alert alert-danger bg-red-500 w-1/4 py-3 absolute top-2 right-[40%] text-white text-center rounded z-[10]">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('topic_error_id')?.remove();
            }, 3000);
        </script>
        @endif

        @if ($errors->any())
        <div id="custom-alert-error" class="fixed top-5 right-[25%] p-4 bg-red-500 text-white rounded shadow-md z-[10]">
            <strong>Error:</strong> {{ $errors->first() }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('custom-alert-error')?.remove();
            }, 3000);
        </script>
        @endif

@if (session('success'))
        <div id="custom-alert-success" class="fixed top-5 right-[45%] p-4 bg-yellow-500 text-white rounded shadow-md z-[10]">
            {{ session('success') }}
        </div>

<script>
    setTimeout(function() {
        document.getElementById('custom-alert-success')?.remove();
        document.getElementById('topic_modal')?.classList.add('hidden'); // Form hide kare success pe
    }, 3000);
</script>
@endif

<script>
    // Close button pe click hone par form hide ho
    document.getElementById("close_topic").addEventListener("click", function() {
        document.getElementById("topic_modal").classList.add("hidden");
    });
</script>




<!--- ************************************************** --->
    <!-- Modal for Image Preview -->
<!--- ************************************************** --->


<!-- Image Modal -->
<div id="image_modal"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center flex-col gap-3">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full relative">
        <button id="close_modal" type="button"
            class="absolute top-4 right-4 bg-red-500 py-1 px-3 rounded-full text-white hover:bg-gray-700">X</button>
        <div class="flex justify-center">
            <img id="modal_image" src="" alt="Image Preview" class="max-w-full h-auto">
        </div>
    </div>
</div>

<!--- ************************************************** --->
    <!-- Modal for Image Preview -->
<!--- ************************************************** --->






    <!-- JavaScript -->
    <script>


    document.getElementById("close_modal").addEventListener("click", function() {
        document.getElementById("image_modal").classList.add("hidden");
    });
        document.getElementById('add_question').addEventListener('click', function() {
            document.getElementById('show_form').classList.remove('hidden');
        });


        function openModal(imageUrl) {
            document.getElementById('modal_image').src = imageUrl;
            document.getElementById('image_modal').classList.remove('hidden');
        }

        document.getElementById('close_modal').addEventListener('click', function() {
            document.getElementById('image_modal').classList.add('hidden');
        });

        document.getElementById('add_topic').addEventListener('click', function() {
            document.querySelector('.topic_add').classList.remove('hidden');
        });

        document.getElementById('close_topic').addEventListener('click', function() {
            document.querySelector('.topic_add').classList.add('hidden');
        });


        function enableUploadButton(questionId) {
        const fileInput = document.getElementById('image_input_' + questionId);
        const uploadButton = document.getElementById('upload_button_' + questionId);

        // If file is selected, enable the button and allow click
        if (fileInput.files.length > 0) {
            uploadButton.disabled = false;  // Enable the button
            uploadButton.classList.remove('disabled:opacity-50'); // Remove opacity if enabled
            uploadButton.setAttribute('onclick', 'this.form.submit()');  // Allow the button to submit the form
        } else {
            uploadButton.disabled = true;  // Disable the button
            uploadButton.classList.add('disabled:opacity-50'); // Add opacity to indicate disabled state
            uploadButton.setAttribute('onclick', 'return false;');  // Disable the button click
        }
    }



    </script>

</body>

</html>
