@extends('header')
@section('section')
    <div class="w-full mx-auto bg-white p-5 shadow-lg rounded-lg relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-center">Users List</h2>
            <button id="addUserBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Add User</button>
        </div>

    @error('password')
        <span id="password-error" class="px-5 py-1 text-sm absolute top-1 left-[20%] bg-red-500 text-white rounded-md">{{ $message }}</span>
    @enderror

    <script>
        setTimeout(function() {
            let errorMsg = document.getElementById("password-error");
            if (errorMsg) {
                errorMsg.style.display = "none";
            }
        }, 3000); // 5000 milliseconds = 5 seconds
    </script>


@error('email')
<span id="email_error" class="text-white bg-red-500 absolute top-2 left-[20%] p-2 rounded-md text-sm">{{ $message }}</span> <!-- Show duplicate email error -->
@enderror

<script>
    setTimeout(function() {
        let errorMsg = document.getElementById("email_error");
        if (errorMsg) {
            errorMsg.style.display = "none";
        }
    }, 3000); // 5000 milliseconds = 5 seconds
</script>
        <!-- Hidden Form -->
        <div id="userForm" class="hidden absolute transform top-2 right-[30%] bg-white p-5 shadow-xl rounded-lg w-96 border border-gray-300">
            <h3 class="text-xl font-bold mb-3 text-center">Add New User</h3>
            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-gray-700">UserName:</label>
                    <input type="text" name="username" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Email:</label>
                    <input type="email" name="email" class="w-full border p-2 rounded" required>

                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Password:</label>
                    <input type="password" name="password" class="w-full border p-2 rounded" required>
                    {{-- <input type="password" name="password" class="form-control"> --}}

                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Role:</label>
                    <select name="role" class="w-full border p-2 rounded" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="flex justify-between">
                    <button type="button" id="closeFormBtn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Close</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Submit</button>
                </div>
            </form>

        </div>

        @if(session('error'))
            <div id="email_id" class="alert alert-danger bg-red-500 absolute top-2 right-[25%] text-white rounded-md p-4">
                {{ session('error') }}
            </div>

            <script>
                setTimeout(function() {
                    document.getElementById('email_id')?.remove();
                }, 3000);
            </script>
        @endif

        @if(session('success'))
            <div id="success_email_id" class="alert alert-success bg-green-500 absolute top-2 right-[25%] text-white rounded-md p-4">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(function() {
                    document.getElementById('success_email_id')?.remove();
                }, 3000);
            </script>
        @endif


        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300">
                <thead>
                    <tr class="bg-purple-500 text-white">
                        <th class="py-2 px-4 border">Sr No</th>
                        <th class="py-2 px-4 border">Username</th>
                        <th class="py-2 px-4 border">Email</th>
                        {{-- <th class="py-2 px-4 border">Password</th> --}}
                        <th class="py-2 px-4 border">Role</th>
                        <th class="py-2 px-4 border">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50 text-center">
                    @foreach ($user_lists as $list)
                    <tr class="hover:bg-gray-200">
                        <td class="py-2 px-4 border">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border">{{ $list->username }}</td>
                        <td class="py-2 px-4 border">{{ $list->email }}</td>
                        {{-- <td class="py-2 px-4 border">{{ $list->password }}</td> --}}
                        <td class="py-2 px-4 border">{{ $list->role }}</td>
                        <td class=" flex justify-center items-center gap-2">
                            <a href="{{ route('login.edit', ['id'=> $list->login_id]) }}" class=""><img
                                src="{{ asset('assets/editsymbol.png') }}" class="w-8 h-8"></a>
                            <a href="{{ route('login.delete', ['id'=> $list->login_id]) }}" class=""><img
                                src="{{ asset('assets/deletesymbol.png') }}" class="w-8 h-8"></a>
                            <a href="javascript:void(0);" onclick="togglePasswordInput({{ $list->login_id }})" class="text-white rounded-md "><img
                                src="{{ asset('assets/key.png') }}" class="w-8 h-8"></a>

                            <!-- Hidden Password Update Form -->
                            <form id="password-form-{{ $list->login_id }}" action="{{ route('login.password.update', ['id'=> $list->login_id]) }}" method="POST" class="w-1/2 p-0 hidden border rounded bg-gray-100 flex gap-2">
                                @csrf
                                <input type="password" name="new_password" placeholder="Enter new password" class="border p-1 text-sm rounded w-3/4 " required>

                                @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <button type="submit" class="bg-blue-500 text-white text-sm px-1 rounded-md hover:bg-blue-800">Update</button>
                                <button type="button" onclick="togglePasswordInput({{ $list->login_id }})" class="px-3 bg-red-500 text-white text-sm text-center rounded-md hover:bg-red-800">x</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('addUserBtn').addEventListener('click', function() {
            document.getElementById('userForm').classList.toggle('hidden');
        });
        document.getElementById('closeFormBtn').addEventListener('click', function() {
            document.getElementById('userForm').classList.add('hidden');
        });

        // Change Password JS
        function togglePasswordInput(id) {
            let form = document.getElementById("password-form-" + id);
            form.classList.toggle("hidden");
        }
    </script>
@endsection
