<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Quiz</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" class="rounded-md">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-purple-700 to-blue-200 min-h-screen flex flex-col justify-between font-semibold select-none">
    <div class="absolute top-0 flex justify-center m-1">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-16 sm:w-24 md:w-32 lg:w-32 xl:w-32 rounded-md shadow-md">

    </div>
    <a href="{{ route('weekly.quiz') }}" class="absolute top-1 right-1 ">
        <img src="{{ asset('assets/back.png') }}" alt="Logo" class="h-12 w-12 ">
    </a>

    <!-- Main content -->
    <div class="flex-grow flex justify-center items-center p-4 ">
        <div class="w-full lg:h-[300px] bg-white max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl bg-white rounded-md font-cursive flex flex-col justify-center items-center gap-4 sm:text-2xl md:text-2xl lg:text-2xl xl:text-3xl shadow-lg p-6 text-center">
            <h1 class="text-purple-800">
                This quiz is <strong class="text-red-500"> Inactive </strong> for now.
                </h1> 
            <h2 class="lg:text-2xl">
                In the meantime, feel free to participate in our other available quizzes!
            </h2>
            <a href="{{ route('weekly.quiz') }}" class="bg-purple-800 text-white text-base px-5 py-1 font-semibold rounded-full">
                Go to Home
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-purple-900 text-white text-center p-4 text-xs sm:text-sm md:text-base">
        <p>&copy; Rohan Book Company Pvt. Ltd. All Rights Reserved</p>
    </footer>
</body>
</html>
