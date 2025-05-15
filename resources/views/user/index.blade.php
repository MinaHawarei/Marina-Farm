<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="p-6">
        {{-- رسائل التنبيه --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-700">&times;</button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                <div class="flex justify-between items-center">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-700">&times;</button>
                </div>
            </div>
        @endif

        <h1>
            <span class="text-2xl font-bold">Users</span>
        </h1>

        <table class="w-full border border-gray-400 text-center" id="user-table">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">Name</th>
                    <th class="border px-2 py-1">Username</th>
                    <th class="border px-2 py-1">Email</th>
                    <th class="border px-2 py-1">Role</th>
                    <th class="border px-2 py-1">Password</th>
                    <th class="border px-2 py-1">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr data-id="{{ $user->id }}">
                        <td class="border px-2 py-1">{{ $user->id }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $user->name }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $user->username }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $user->email }}</td>
                        <td class="border px-2 py-1">
                            <select class="w-full border-none bg-transparent focus:outline-none text-center">
                                <option value="admin" @selected($user->hasRole('admin'))>admin</option>
                                <option value="accountant" @selected($user->hasRole('accountant'))>accountant</option>
                                <option value="employee" @selected($user->hasRole('employee'))>employee</option>
                            </select>
                        </td>
                        <td class="border px-2 py-1" contenteditable="true" placeholder="Leave blank if unchanged"></td>
                        <td class="border px-2 py-1">
                            <button onclick="saveUser(this, {{ $user->id }})" class="bg-blue-600 text-white px-2 py-1 text-sm rounded">Save</button>
                        </td>
                    </tr>
                @endforeach

                <!-- Row to Add New User -->
                <tr data-id="new">
                    <td class="border px-2 py-1 text-gray-400">New</td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1">
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value=" "> </option>
                            <option value="employee">employee</option>
                            <option value="accountant">accountant</option>
                            <option value="admin">admin</option>

                        </select>
                    </td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1">
                        <button onclick="saveUser(this, 'new')" class="bg-green-600 text-white px-2 py-1 text-sm rounded">Add</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <form id="user-form" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="PUT" id="form-method">
        <input type="hidden" name="id" id="form-id">
        <input type="hidden" name="name" id="form-name">
        <input type="hidden" name="username" id="form-username">
        <input type="hidden" name="email" id="form-email">
        <input type="hidden" name="role" id="form-role">
        <input type="hidden" name="password" id="form-password">
    </form>

    <script>
        function saveUser(button, userId) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            const select = row.querySelector('select');

            const data = {
                id: userId,
                name: cells[1].innerText.trim(),
                username: cells[2].innerText.trim(),
                email: cells[3].innerText.trim(),
                role: select.value,
                password: cells[5].innerText.trim()
            };

            // تعبئة الفورم
            document.getElementById('form-id').value = data.id;
            document.getElementById('form-name').value = data.name;
            document.getElementById('form-username').value = data.username;
            document.getElementById('form-email').value = data.email;
            document.getElementById('form-role').value = data.role;
            document.getElementById('form-password').value = data.password;

            const form = document.getElementById('user-form');
            const methodInput = document.getElementById('form-method');

            if (userId === 'new') {
                form.action = "{{ route('user.store') }}";
                methodInput.value = 'POST';
            } else {
                form.action = "{{ url('/user') }}/" + userId;
                methodInput.value = 'PUT';
            }

            form.submit();
        }
    </script>
</x-app-layout>
