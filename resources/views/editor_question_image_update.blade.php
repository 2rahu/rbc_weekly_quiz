<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Question</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-700 w-screen h-screen flex justify-center items-center overflow-hidden ">

    <div class="w-[80%] h-[60%] p-8 bg-white shadow-lg rounded-lg flex justify-center items-center gap-10">


        <div class="w-1/2 h-full bg-gray-400">
            {{-- <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Update Image</h2> --}}
            <div class="mb-4 w-full h-full flex justify-center items-center flex-col gap-1">
                <label class="block font-medium text-white text-2xl">Existing Image</label>
                <div class="w-1/2 h-1/2 bg-gray-100 border border-gray-500 rounded-md">
                    <img src="{{ asset('storage/' . $image_update->filePath) }}" alt="" class="w-full h-full">
                </div>
            </div>
        </div>


        <div class="w-1/3 h-1/2 bg-red">
            <form action="{{ route('quiz.editor.update.image', ['id'=>$image_update->ques_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file_path" class="block text-sm font-medium text-gray-600">Upload New Image</label>
                    <input type="file" name="file_path" id="file_path" class="w-full mt-2 p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" accept="image/*">
                    @error('file_path')
                        <span class="text-red-500 text-xs"></span>
                    @enderror
                </div>
                <div class="mb-6">
                    <button type="submit" class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Update Question
                    </button>
                </div>
            </form>

        </div>

        <!-- Form Starts -->

        <!-- Form Ends -->
    </div>

</body>
</html>
