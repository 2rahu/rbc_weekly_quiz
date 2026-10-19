<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Quiz</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" class="rounded-md">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes zoomEffect {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .highlight-quiz {
            background: linear-gradient(to right, orange, yellow);
            animation: zoomEffect 1.5s infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-purple-700 to-blue-200 min-h-screen flex flex-col">
    <div class="flex-1">
        <main class="p-6">
            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white p-6 rounded-xl shadow-lg mb-6 sticky top-0 z-10 flex justify-between">
                <div class="flex justify-center items-center gap-5">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-8 w-auto rounded-md shadow-md">
                    <h1 class="text-xl font-semibold">Weekly Quizzes</h1>
                </div>

                <a href="{{ route('login.index') }}" class="hover:bg-gray-200 shadow-md bg-white px-3 py-1 text-gray-700 rounded-md">Login</a>
            </div>

            @php
                use Carbon\Carbon;
                $today = Carbon::now();
                $upcomingSaturday = $today->copy()->next(Carbon::SATURDAY);

                $upcomingQuizzes = $quizStatus->filter(fn($quiz) => Carbon::parse($quiz->quiz_launch_date)->isSameDay($upcomingSaturday));
            @endphp

            @if ($upcomingQuizzes->isNotEmpty())
                <h3 class="text-xl font-semibold text-white p-2 bg-yellow-500 rounded-lg border-2 text-center m-2">Upcoming Quiz ({{ $upcomingSaturday->format('d M Y') }})</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
                    @foreach ($upcomingQuizzes as $quiz)
                        <div class="quiz-card bg-white p-4 rounded-lg shadow-lg flex flex-col items-center gap-2">
                            <div class="flex justify-between w-full">
                                <p class="text-md p-2 rounded-full bg-blue-300 font-semibold w-10 h-10 flex justify-center items-center shadow-md shadow-blue-500">
                                    {{ str_pad($quiz->quiz_set_id, 2, '0', STR_PAD_LEFT) }}
                                </p>
                                <p class="text-lg font-bold text-gray-700">{{ Carbon::parse($quiz->quiz_launch_date)->format('d-m-Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @php
                $currentMonthNum = now()->month;
                $quizzesByMonth = $quizStatus->groupBy(fn($quiz) => Carbon::parse($quiz->quiz_launch_date)->format('F'));
                $monthsWithNumbers = $quizzesByMonth->mapWithKeys(fn($quizzes, $monthName) => [Carbon::parse($monthName . ' 1')->month => $quizzes]);
                $sortedMonths = $monthsWithNumbers->sortKeys()->put($currentMonthNum, $monthsWithNumbers->pull($currentMonthNum))->reverse();
            @endphp

            <div class="mb-6">
               @foreach ($sortedMonths as $monthNum => $quizzes)
    @php
        // Ensure $quizzes is a valid collection
        $activeQuizzes = $quizzes ? $quizzes->filter(fn($quiz) => $quiz->is_active == 1) : collect();
        $monthName = Carbon::create()->month($monthNum)->format('F');
    @endphp

    @if ($activeQuizzes->isNotEmpty())
        <h3 class="text-xl font-semibold text-white p-2 bg-purple-700 rounded-lg border-2 text-center m-2">{{ $monthName }} 2025</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
            @foreach ($activeQuizzes as $quiz)
                @php
                    $quizDate = Carbon::parse($quiz->quiz_launch_date);
                    $isToday = $quizDate->isSameDay($today);
                @endphp
                <div class="quiz-card bg-white p-4 rounded-lg shadow-lg flex flex-col items-center gap-2 {{ $isToday ? 'highlight-quiz' : '' }}">
                    <div class="flex justify-between w-full">
                        <p class="text-md p-2 rounded-full bg-red-300 font-semibold w-10 h-10 flex justify-center items-center shadow-md shadow-red-500">
                            {{ str_pad($quiz->quiz_set_id, 2, '0', STR_PAD_LEFT) }}
                        </p>
                        <p class="text-lg font-bold text-gray-700">{{ $quizDate->format('d-m-Y') }}</p>
                    </div>
                    <a href="{{ route('play.quiz', ['id' => $quiz->quiz_set_id]) }}" class="text-md bg-green-500 px-3 py-1 text-white rounded-md hover:bg-green-600">🎮 Play Quiz</a>
                </div>
            @endforeach
        </div>
    @endif
@endforeach

            </div>
        </main>
    </div>

    <footer class="bg-purple-900 text-white text-center p-4 mt-4">
        <p class="text-sm">&copy; Rohan Book Company Pvt. Ltd. All Rights Reserved</p>
    </footer>
</body>
</html>
