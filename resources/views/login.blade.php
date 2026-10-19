<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" class="rounded-md">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-700 min-h-screen flex items-center justify-center">
    <img src="{{ asset('assets/logo.png') }}" alt="Admin Logo" class="w-[70px] h-[50px] absolute top-1 left-1 rounded-md shadow-md">
    <div class="bg-white shadow-2xl rounded-lg flex overflow-hidden w-full max-w-4xl">
        <!-- Illustration Section -->
        <div class="w-1/2 bg-gray-100 p-6 hidden md:flex items-center justify-center">
            <img src="{{ asset('assets/login.png') }}" alt="" class="w-80 h-auto">
        </div>

        <!-- Login Form Section -->
        <div class="w-full md:w-1/2 p-8 md:p-12 bg-purple-600 rounded-r-lg">
            <h2 class="text-3xl font-bold text-white text-center mb-8">Welcome Back</h2>
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <input type="email" name="email" placeholder="Username" class="w-full px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 bg-white placeholder-gray-500">

                </div>

                <div>
                    <input type="password" name="password" placeholder="Password" class="w-full px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 bg-white placeholder-gray-500">
                    {{-- @error('password')
                    <div id="password-msg" class="text-red-500">{{ $message }}</div>
                    <script>
                        setTimeout(() => {
                            document.getElementById('password-msg').classList.add('hidden');
                        }, 2000);
                        </script>
                @enderror --}}
                </div>
                @error('password')
                <p id="password-error" class="text-white text-sm mt-1">{{ $message }}</p>
                <script>
                    setTimeout(() => {
                        document.getElementById('password-error').classList.add('hidden');
                    }, 2000);
                    </script>
                @enderror

                @error('email')
                <div id="email-msg" class="text-white">{{ $message }}</div>

                <script>
                    setTimeout(() => {
                        document.getElementById('email-msg').classList.add('hidden');
                    }, 2000);
                    </script>
            @enderror
                <div class="flex items-center justify-between text-sm text-white">
                </div>
                <button type="submit" class="w-full bg-yellow-400 text-purple-800 py-3 rounded-md font-bold hover:bg-yellow-500 transition">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>
