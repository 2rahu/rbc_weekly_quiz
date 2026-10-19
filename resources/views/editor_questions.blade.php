@extends('header')
@section('section')

<div class="w-full container mx-auto bg-white p-2 shadow-md rounded-lg relative">
    <!-- Add Question Button -->
    <a href="{{ route('quiz.editor.form') }}" id="add_question" class="absolute bg-green-500 text-white font-semibold px-6 py-2 rounded-full top-3 right-3 hover:bg-green-800 transition-all">
       + Add Questions
    </a>

    <h2 class="text-2xl font-bold mb-4 text-gray-700 text-center">Editors Questions List</h2>


<!-- Success Message -->
{{-- @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif --}}

<!-- Error Message -->
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Validation Errors -->
@if ($errors->any())
    <div id="img-error" class="alert alert-danger bg-red-500 rounded text-white p-2 absolute top-1 right-[35%]">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>


    <script>
        setTimeout(() => {
            document.getElementById('img-error').classList.add('hidden');
        }, 3000);

        </script>
@endif


    <!-- Table -->
    <div class="w-full max-h-[90vh] overflow-y-auto overflow-x-auto border border-gray-300 rounded-lg">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200 text-gray-700 sticky top-0">
                <tr>
                    <th class="p-1  text-sm border">Sr No</th>
                    <th class="p-1  text-sm border">Id</th>
                    <th class="p-1  text-sm border">Topic</th>
                    <th class="p-1  text-sm border">Question</th>
                    <th class="p-1 px-8  text-sm border">Image</th>
                    <th class="p-1  text-sm border">Option 1</th>
                    <th class="p-1  text-sm border">Option 2</th>
                    <th class="p-1  text-sm border">Option 3</th>
                    <th class="p-1  text-sm border">Option 4</th>
                    <th class="p-1  text-sm border">Answer</th>
                     <th class="p-1  text-sm border">User</th>
                    <th class=" text-sm border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($editors as $question)
                <tr class="border-t transition
                {{ $question->status === 'disabled' ? 'bg-green-300 text-black' : 'bg-white' }}">
                <td class="p-3 text-sm border">{{ $loop->iteration }}</td>

                    <td class="p-3 text-sm border text-center">
                        {{ $question->ques_id }}
                        <a href="{{ route('quiz.temp.store', ['id'=>$question->ques_id]) }}" class="m-1 bg-yellow-500 px-2 py-1 rounded-md">Add</a>
                    </td>



                    <td class="p-1 text-sm border">{{ $question->quiztopics->topic_name }}</td>
                    <td class="p-1 text-sm border"><textarea readonly=true class="text-center">{{ $question->question }}</textarea></td>
                    <td class="text-sm flex justify-center items-center flex-col gap-1">
                        @if(!empty($question->filePath))
                        <a href="{{ route('quiz.editor.delete.image', $question->ques_id) }}" class=""><img
                            src="{{ asset('assets/deletesymbol.png') }}" class="w-5 h-5"></a>
                            <img src="{{ asset('storage/' . $question->filePath) }}" width="70" class="cursor-pointer rounded-md shadow-md transition-transform hover:scale-105"
                                onclick="openModal('{{ asset('storage/' . $question->filePath) }}')">
                            <form action="{{ route('quiz.editor.update.image', ['id'=>$question->ques_id]) }}" method="POST" enctype="multipart/form-data" id="image_upload_form_{{ $question->ques_id }}" class="image_upload_form text-md w-15 flex flex-col justify-center items-center">
                                @csrf
                                <input type="file" name="file_path" alt="" class="text-[7px] w-full p-1" id="image_input_{{ $question->ques_id }}" onchange="enableUploadButton({{ $question->ques_id }})">
                                <button type="submit" id="upload_button_{{ $question->ques_id }}" class="disabled:opacity-50" disabled onclick="return false;">
                                    <img src="{{ asset('assets/file-upload.png') }}" class="w-6 h-6">
                                </button>
                            </form>
                        @else
                            <form action="{{ route('quiz.editor.update.image', ['id'=>$question->ques_id]) }}" method="POST" enctype="multipart/form-data" id="image_upload_form_{{ $question->ques_id }}" class="image_upload_form text-md w-15 flex flex-col justify-center items-center">
                                @csrf
                                <input type="file" name="file_path" alt="" class="text-[7px] w-full p-1" id="image_input_{{ $question->ques_id }}" onchange="enableUploadButton({{ $question->ques_id }})">
                                <button type="submit" id="upload_button_{{ $question->ques_id }}" class="disabled:opacity-50" disabled onclick="return false;">
                                    <img src="{{ asset('assets/file-upload.png') }}" class="w-6 h-6">
                                </button>
                            </form>
                        @endif

                    </td>
                    <td class="p-1 text-sm border"><textarea readonly=true class="text-center">{{ $question->option_1 }}</textarea></td>
                    <td class="p-1 text-sm border"><textarea readonly=true class="text-center">{{ $question->option_2 }}</textarea></td>
                    <td class="p-1 text-sm border"><textarea readonly=true class="text-center">{{ $question->option_3 }}</textarea></td>
                    <td class="p-1 text-sm border"><textarea readonly=true class="text-center">{{ $question->option_4 }}</textarea></td>
                    <td class="p-1 text-sm border font-bold text-green-600"><textarea readonly=true class="text-center">{{ $question->answer }}</textarea></td>
                    <td class="p-1 text-sm border font-bold text-green-600"><textarea readonly=true class="text-center">{{ $question->userlist->username }}</textarea></td>
                    <td class="flex justify-center items-center flex-col gap-2">
                        <a href="{{ route('quiz.editor.edit', $question->ques_id) }}" class=""><img
                            src="{{ asset('assets/editsymbol.png') }}" class="w-8 h-8"></a>
                        <a href="{{ route('quiz.editor.delete', $question->ques_id) }}" class=""><img
                            src="{{ asset('assets/deletesymbol.png') }}" class="w-8 h-8"></a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>



    </div>



</div>



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



</div>
        @if(session('success'))
        <div id="data-success-inserted" class="bg-green-500 text-white p-4 rounded absolute top-0 right-[35%]">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('data-success-inserted').classList.add('hidden');
            }, 3000);

            </script>
        @endif

        @if(session('error'))
        <div id="data-not-inserted" class="bg-red-500 text-white p-4 rounded absolute top-0 right-[35%]">
            {{ session('error') }}
        </div>


        <script>
            setTimeout(() => {
                document.getElementById('data-not-inserted').classList.add('hidden');
            }, 3000);

            </script>
        @endif


<!-- JavaScript -->
<script>



function openModal(imageUrl) {
            document.getElementById('modal_image').src = imageUrl;
            document.getElementById('image_modal').classList.remove('hidden');
        }

        document.getElementById('close_modal').addEventListener('click', function() {
            document.getElementById('image_modal').classList.add('hidden');
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

@endsection
