<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" class="rounded-md">
    <title>Dashboard</title>
    <link rel="icon" sizes="16x16" href="{{ asset('logo.png') }}">
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
            background: rgb(239, 246, 246);
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
<body class="bg-gray-100 overflow-hidden">
    <div class="flex h-screen">
        <img src="{{ asset('assets/logo.png') }}" alt="Admin Logo" class="w-[50px] h-[38px] absolute rounded-md">
        <!-- Sidebar -->
        <div class="bg-gradient-to-r from-purple-500 to-blue-400 text-white w-52 p-5">
            <div class="text-center mb-8">
                <div class="w-[150px] h-[150px] mx-auto bg-white rounded-full">
                    <img src="{{ asset('assets/admin_logo.png') }}" alt="Admin Logo" class="w-full h-auto">
                </div>
                <h2 class="mt-2 text-lg font-semibold">Admin</h2>
            </div>
            <nav>
                <ul>

                    <li class="mb-4">
                        <a href="{{ route('user.details') }}" onclick="showSection('question-data')" class="flex items-center text-md space-x-2 hover:text-gray-700">
                            <span>●</span> <span>User List</span>
                        </a>
                    </li>

                    <li class="mb-4">
                        <a href="{{ route('quiz.topic.index') }}" onclick="showSection('course-section')" class="flex items-center text-sm space-x-2 hover:text-gray-700">
                            <span>●</span> <span>Quiz Topic</span>
                        </a>
                    </li>

                    <li class="mb-4">
                        <a href="{{ route('quiz.editor.index') }}" onclick="showSection('question-data')" class="flex items-center text-sm space-x-2 hover:text-gray-700">
                            <span>●</span> <span>Editor Questions</span>
                        </a>
                    </li>

                    <li class="mb-4">
                        <a href="{{ route('quiz.temp.index') }}" onclick="showSection('question-data')" class="flex items-center text-sm space-x-2 hover:text-gray-700">
                            <span>●</span> <span>Selected Questions</span>
                        </a>
                    </li>

                    <li class="mb-4">
                        <a href="{{ route('quiz.question.index') }}" onclick="showSection('question-data')" class="flex items-center text-sm space-x-2 hover:text-gray-700">
                            <span>●</span> <span>Questions</span>
                        </a>
                    </li>

                    <li class="mb-4">
                        <a href="{{ route('quiz.set.index') }}" onclick="showSection('student-section')" class="flex items-center text-sm space-x-2 hover:text-gray-700">
                            <span>●</span> <span>Weekly Quiz</span>
                        </a>
                    </li>

                    <li class="mb-4">
                        <a href="{{ route('weekly.quiz') }}" onclick="showSection('student-section')" class="flex items-center text-sm space-x-2 hover:text-gray-700">
                            <span>●</span> <span>Weekly Quiz History</span>
                        </a>
                    </li>

                    <li class="mb-4">
                        <a href="{{ route('login.index') }}" class="flex items-center text-sm space-x-2 hover:text-gray-700">
                            <span>●</span> <span>Log Out</span>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
<!-- Side bar -->


        <!-- Main Content -->
        <div class="flex-1 p-3 w-full">
            {{-- <div class="flex justify-end">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Logout</button>
            </div> --}}

            <!-- Dashboard Section -->
            <div id="dashboard-section" class=" w-full h-full flex justify-start items-start flex-col gap-2 content-section">
                @yield('section')
            </div>

            <!-- Questions Table -->
             {{-- <div class="text-center mt-10 text-gray-500 absolute bottom-0 right-[38%]">
                <p>Rohan Book Company Pvt. Ltd.</p>
                <p>Copyright © Online Quiz 2025</p>
            </div> --}}
        </div>
    </div>

</body>
</html>
