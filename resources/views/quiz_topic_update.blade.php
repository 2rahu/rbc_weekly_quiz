@extends('header')
@section('section')

    <div class="bg-gray-700 w-full h-full p-6 rounded-lg shadow-lg flex justify-center items-center">



        @if ($errors->any())
        <div id="custom-alert-error" class="fixed top-5 right-1 transform -translate-x-1/2 p-4 bg-red-500 text-white rounded">
            {{ $errors->first() }}
        </div>

        <script>
            // Timeout to hide the error alert after 3 seconds
            setTimeout(function() {
                var alertElement = document.getElementById('custom-alert-error');
                if (alertElement) {
                    alertElement.style.display = 'none'; // Hide the alert
                }
            }, 3000); // 3 seconds timeout
        </script>
    @endif

    @if (session('success'))
    <div id="custom-alert-success" class="fixed top-5 right-1 transform -translate-x-1/2 p-4 bg-green-500 text-white rounded">
        {{ session('success') }}
    </div>

    <script>
        // Timeout to hide the success alert after 3 seconds
        setTimeout(function() {
            var alertElement = document.getElementById('custom-alert-success');
            if (alertElement) {
                alertElement.style.display = 'none'; // Hide the alert
            }
        }, 3000); // 3 seconds timeout
    </script>
@endif


        <div class="w-1/2 h-1/2 bg-white rounded-md flex justify-center items-center flex-col">
            <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">Update Topic</h2>
            <form action="{{ route('quiz.topic.update', ['id' => $topics->topic_id]) }}" method="POST" class="w-1/2">
                @csrf
                @method('PUT')

                <label for="topic_name" class="block text-black font-medium mb-1">Update Topic Name:</label>
                <input type="text" id="topic_name" name="topic_name" value="{{ $topics->topic_name }}"
                       class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4" required>

                <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition">
                    Update Topic
                </button>
            </form>



        </div>

        <button onclick="window.history.back();"
                class=" absolute top-5 right-8 w-32 mt-3 bg-red-500 text-white py-2 rounded-md hover:bg-red-600 transition">
            Back
        </button>
    </div>
    @endsection
