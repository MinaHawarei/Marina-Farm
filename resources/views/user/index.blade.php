<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="flex-1 overflow-y-auto p-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-700">&times;</button>
                </div>
            </div>
        @endif

        <h3 class="text-lg font-bold mb-4">Users List</h3>

        <table class="table-auto w-full text-sm border border-gray-300 mb-8">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Edit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->username }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td class="px-4 py-2 text-center">
                            <button onclick="openEditForm({{ $user->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">Edit</button>
                        </td>
                    </tr>

                    {{-- Edit Form --}}
                    <tr id="edit-form-{{ $user->id }}" class="hidden bg-gray-50 border-b">
                        <td colspan="6">
                            <form action="{{ route('user.update', $user->id) }}" method="POST" class="p-4 space-y-2">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium">Name</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded px-2 py-1">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium">Username</label>
                                        <input type="text" name="username" value="{{ $user->username }}" class="w-full border rounded px-2 py-1">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium">Email</label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-2 py-1">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium">Role</label>
                                        <select name="role" class="w-full border rounded px-2 py-1">
                                            <option value="admin" @if($user->hasRole('admin')) selected @endif>admin</option>
                                            <option value="accountant" @if($user->hasRole('accountant')) selected @endif>accountant</option>
                                            <option value="employee" @if($user->hasRole('employee')) selected @endif>employee</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium">New Password (optional)</label>
                                        <input type="password" name="password" class="w-full border rounded px-2 py-1" placeholder="Leave blank">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Save</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Add New User --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Add New User</h3>
            <form action="{{ route('user.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Name</label>
                        <input type="text" name="name" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Username</label>
                        <input type="text" name="username" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Role</label>
                        <select name="role" class="w-full border rounded px-2 py-1" required>
                            <option value="admin">admin</option>
                            <option value="accountant">accountant</option>
                            <option value="employee">employee</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Password</label>
                        <input type="password" name="password" class="w-full border rounded px-2 py-1" required>
                    </div>
                </div>

                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Add User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditForm(userId) {
            const form = document.getElementById(`edit-form-${userId}`);
            form.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
