<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6">Manage Users</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 text-left">Name</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Role</th>
                    <th class="py-2 px-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-t">
                        <td class="py-2 px-4">{{ $user->name }}</td>
                        <td class="py-2 px-4">{{ $user->email }}</td>
                        <td class="py-2 px-4">{{ ucfirst($user->role) }}</td>
                        <td class="py-2 px-4">
                            @can('admin')
                                <form method="POST" action="{{ route('admin.promote', $user->id) }}">
                                    @csrf
                                    <select name="role" class="border px-2 py-1 text-sm rounded">
                                        <option value="free" @if($user->role === 'free') selected @endif>Free</option>
                                        <option value="premium" @if($user->role === 'premium') selected @endif>Premium</option>
                                        <option value="admin" @if($user->role === 'admin') selected @endif>Admin</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-sm px-2 py-1 rounded ml-2">
                                        Update Role
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
