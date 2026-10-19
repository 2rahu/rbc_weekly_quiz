@extends('header')
@section('section')
    <div class="w-full h-full mx-auto p-5 relative bg-purple-400 rounded-lg">
        {{-- <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-center">Users List</h2>
            <button id="addUserBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Add User</button>
        </div> --}}

        <!-- Hidden Form -->
        <a href="{{ route('user.details') }}" id="closeFormBtn" class="absolute right-5 bg-red-500 text-white text-3xl px-5 py-1 rounded-full hover:bg-red-700">x</a>
        <div id="userForm" class=" absolute transform top-[15%] right-[30%]  bg-white p-5 shadow-xl rounded-lg w-96 border border-gray-300">
            <h3 class="text-xl font-bold mb-3 text-center">Update User</h3>
            <form action="{{ route('login.update', ['id'=>$edit_users->login_id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-gray-700">UserName:</label>
                    <input type="text" value="{{ $edit_users->username }}" name="username" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Email:</label>
                    <input type="email" value="{{ $edit_users->email }}" name="email" class="w-full border p-2 rounded" required>
                </div>

                @error('email')
                <span id="email_error" class="text-white bg-red-500 absolute top-0 left-[15%] p-1 rounded-md text-sm">{{ $message }}</span> <!-- Show duplicate email error -->
                @enderror

                <script>
                    setTimeout(function() {
                        let errorMsg = document.getElementById("email_error");
                        if (errorMsg) {
                            errorMsg.style.display = "none";
                        }
                    }, 3000); // 5000 milliseconds = 5 seconds
                </script>
                <div class="mb-3">
                    {{-- <label class="block text-gray-700">Role:</label> --}}
                    {{-- <input type="role" value="{{ $edit_users->role }}" name="role" class="w-full border p-2 rounded" required> --}}
                    <div class="mb-3">
                        <label class="block text-gray-700">Role:</label>
                        <select name="role" class="w-full border p-2 rounded" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            {{-- <option value="editor">Editor</option> --}}
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('user.details') }}" id="closeFormBtn" class="hidden bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Close</a>
                   <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Submit</button>
                </div>
            </form>
        </div>

    </div>

    <script>
        // document.getElementById('closeFormBtn').addEventListener('click', function() {
        //     document.getElementById('userForm').classList.add('hidden');
        // });
    </script>
@endsection
