
@extends('header')
@section('section')
    {{-- <a href="{{ route('quiz.question.index') }}" class="py-2 px-5 bg-white absolute top-2 left-3 rounded">Back</a> --}}

<div class="w-full overflow-hidden h-full bg-purple-700 p-3 rounded-lg shadow-md flex justify-center items-start flex-col gap-2">
        <h1 class="text-4xl pl-5 mb-3 font-semibold text-white">Quiz Sets</h1>


<!-- Duplicate Date update and Delete Error -->
    @if(session('success'))
        <div id="duplicate_date_update_success_updatebtn" class="alert alert-success absolute top-5 right-[30%] bg-green-500 text-white p-2 rounded-md">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('duplicate_date_update_success_updatebtn').classList.add('hidden');
            }, 3000);
            </script>
    @endif

<!-- Duplicate Date update and Delete Error -->

   <!-- Display all data in the table -->
    <div class="w-full h-3/4 bg-white mx-auto p-6 rounded-lg shadow-md flex justify-start items-start flex-col">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">All Data:</h2>

            <!-- Table container with fixed height and scroll -->
            <div class="w-full overflow-y-auto h-full border border-gray-300 rounded-lg shadow-md">
                <table class="w-full bg-white border-collapse">
                    <thead class="bg-purple-500 text-white sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left">Set ID</th>
                            <th class="px-4 py-2 text-left">Set Date</th>
                            <th class="px-4 py-2 text-left">Day</th>
                            <th class="px-4 py-2 text-center">Quiz Status</th>
                            <th class="">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sets as $set)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $set->quiz_set_id }}</td>
                                <td class="px-4 py-2">{{ $set->quiz_launch_date }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($set->quiz_launch_date)->format('l') }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('quiz.set.status',['id'=>$set->quiz_set_id]) }}"
                                        class="px-3 py-1 text-white text-sm rounded-md
                                        {{ $set->is_active == 0 ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                        {{ $set->is_active == 0 ? 'Inactive' : 'Active' }}
                                    </a>
                                </td>
                                <td class="flex gap-2 justify-center items-center">
                                    <a href="{{ route('quiz.set.edit',['id'=>$set->quiz_set_id]) }}"
                                        class=""><img
                                        src="{{ asset('assets/editsymbol.png') }}" class="w-8 h-8"></a></a> |
                                    <a href="{{ route('quiz.set.delete',['id'=>$set->quiz_set_id]) }}"
                                        class=""><img
                                        src="{{ asset('assets/deletesymbol.png') }}" class="w-8 h-8"></a>
                                        |
                                        <a  href="{{ route('play.quiz',['id'=>$set->quiz_set_id]) }}"
                                            class=""><img
                                            src="{{ asset('assets/play.png') }}" class="w-8 h-8">
                                        </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>

</div>

@endsection
