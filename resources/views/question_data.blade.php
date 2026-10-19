@extends('header')
@section('section')
    <div class="w-5/6 h-full overflow-y-auto shadow-lg rounded-lg">
        <!-- Scrollable Container -->
        <div class="overflow-x-auto max-h-full">
            <table class="min-w-full table-auto bg-white rounded-md">
                <thead class="bg-purple-500 text-white sticky top-0">
                    <tr>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Sr No</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Quiz Date</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Topic</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Question</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Image</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Option_1</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Option_2</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Option_3</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Option_4</th>
                        <th class="px-2 py-3 text-center text-md font-cursive ">Answer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $ques)
                    <tr class="border-t">
                        <td class="px-2 py-1 text-sm text-center">{{ $loop->iteration }}</td>
                        <td class="px-2 py-1 text-sm text-center"><textarea readonly=true class="text-center">{{ $ques->quizset->quiz_launch_date }}</textarea></td>
                        <td class="px-2 py-1 text-sm text-center"><textarea readonly=true class="text-center">{{ $ques->quiztopics->topic_name }}</textarea></td>
                        <td class="px-2 py-1 text-sm text-center"><textarea readonly=true class="text-center">{{ $ques->question }}</textarea></td>
                        <td class="px-2 py-1 text-sm text-center">
                            @if($ques->file_path && file_exists(public_path('storage/' . $ques->file_path)))
                                <img src="{{ asset('storage/' . $ques->file_path) }}" width="70">
                            @else
                                {{-- <span class="text-sm">No Image</span> --}}
                            @endif
                        </td>
                        <td class="px-2 py-1 text-sm text-center"><p><textarea readonly=true class="text-center">{{ $ques->option_1}}</textarea></p></td>
                        <td class="px-2 py-1 text-sm text-center"><p><textarea readonly=true class="text-center">{{ $ques->option_2}}</textarea></p></td>
                        <td class="px-2 py-1 text-sm text-center"><p><textarea readonly=true class="text-center">{{ $ques->option_3}}</textarea></p></td>
                        <td class="px-2 py-1 text-sm text-center"><p><textarea readonly=true class="text-center">{{ $ques->option_4}}</textarea></p></td>
                        <td class="px-2 py-1 text-sm text-center"><p><textarea readonly=true class="text-center">{{ $ques->answer}}</textarea></p></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
@endsection
