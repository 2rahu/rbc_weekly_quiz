
@extends('header')
@section('section')
    {{-- <a href="{{ route('quiz.question.index') }}" class="py-2 px-5 bg-white absolute top-2 left-3 rounded">Back</a> --}}

<div class="w-full overflow-hidden h-full bg-gradient-to-r from-purple-500 to-blue-200 mx-auto p-3 rounded-lg shadow-md flex justify-center items-start flex-col gap-4">
        <h1 class="text-4xl pl-5 mb-3 font-semibold text-white">Quiz Topics</h1>


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

        <!-- Form to add Topic ID -->
<div class="w-full h-1/6">
    <form class="mr-10 ml-10 flex justify-center items-center gap-4" action="{{ route('quiz.topic.store') }}" method="POST" class="mb-6">
        @csrf
        <label for="topic_name" class="block text-white text-xl mt-2 w-1/4">Enter Topic Name :</label>
        <input type="text" id="topic_name" name="topic_name" placeholder="Enter Topic Name :" required
            class="w-1/2 px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit"
            class=" w-1/4 bg-blue-500 text-white py-2 px-2 rounded-md hover:bg-blue-600 transition">
            Add Topic
        </button>
    </form>



    @if(session('error'))
    <div id="tooic_error_id" class="alert alert-danger bg-red-500 w-1/4 py-3 absolute top-2 right-[40%] text-white text-center rounded z-[10]">
        {{ session('error') }}
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('tooic_error_id')?.remove();
        }, 3000);
    </script>
    @endif
</div>

   <!-- Display all data in the table -->
    <div class="w-full h-96 bg-white mx-auto p-6 rounded-lg shadow-md flex justify-start items-start flex-col">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">All Data:</h2>

            <!-- Table container with fixed height and scroll -->
            <div class="w-full overflow-y-auto h-full border border-gray-300 rounded-lg shadow-md">
                <table class="w-full bg-white border-collapse">
                    <thead class="bg-gray-200 text-gray-700 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Topic Name</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topics as $topic)
                        <tr class="border">
                            <td class="text-sm px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="text-sm px-4 py-2">{{ $topic->topic_name }}</td>
                            <td class="flex justify-center items-center gap-2">
                                <a href="{{ route('quiz.topic.edit',['id'=>$topic->topic_id]) }}"
                                    class=""><img src="{{ asset('assets/editsymbol.png') }}" class="w-8 h-8"></a>

                                <!-- Check if the topic is used in any quiz -->
                                @if($topic->is_used)
                                    <!-- If used, disable the delete button or hide it -->

                                    <button disabled class="cursor-not-allowed hidden">
                                        <img src="{{ asset('assets/deletesymbol.png') }}" class="w-8 h-8">
                                    </button>
                                @else
                                    <!-- If not used, show the delete button -->
                                    <a href="{{ route('quiz.topic.delete',['id'=>$topic->topic_id]) }}"
                                       class=""><img src="{{ asset('assets/deletesymbol.png') }}" class="w-8 h-8"></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
    </div>

</div>


@endsection
