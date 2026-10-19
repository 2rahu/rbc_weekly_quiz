

@extends('header')
@section('section')

    <div class="bg-gray-700 w-full h-full p-6 rounded-lg shadow-lg flex justify-center items-center">


        <div class="w-1/2 h-1/2 bg-white rounded-md flex justify-center items-center flex-col">
            <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">Update Quiz Set</h2>
            <form action="{{ route('quiz.set.update',['id'=>$sets->quiz_set_id ]) }}" method="POST" class="w-full p-10 flex flex-col gap-3">
                @csrf
                @method('PUT')
                <label for="quiz_launch_date" class="w-full ">Update Quiz Set Date:</label>
                <input type="date" id="quiz_launch_date" name="quiz_launch_date" value="{{ $sets->quiz_launch_date }}" class="w-full bg-gray-200 px-5 py-2 rounded-md" required>
                <button type="submit" class="bg-green-600 px-5 py-2 text-white rounded-md hover:bg-green-800 shadow-md">update Set</button>
            </form>
        </div>
    @if(session('error'))
        <div id="duplicate_date_update" class="alert alert-danger absolute top-5 right-[22%] bg-red-500 text-white p-2 rounded-md">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('duplicate_date_update').classList.add('hidden');
            }, 3000);
            </script>
    @endif



        <button onclick="window.history.back();"
                class=" absolute top-5 right-8 w-32 mt-3 bg-red-500 text-white py-2 rounded-md hover:bg-red-600 transition">
            Back
        </button>
    </div>
    @endsection

