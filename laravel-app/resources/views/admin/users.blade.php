@extends('layouts.main')

@section('content')

@include('partials.nav.system')

<div class="space-y-8">

    <div>
        <h1 class="text-4xl font-bold text-slate-800">Manage Users</h1>
        <p class="text-gray-500 mt-2">All registered users in the system</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-5 py-3 text-left">Name</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-left">Role</th>
                        <th class="px-5 py-3 text-left">Registered</th>
                        <th class="px-5 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="px-5 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-5 py-4 text-gray-600">{{ $user->email }}</td>
                        <td class="px-5 py-4">
                            <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-4 text-center">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Delete this user? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm font-semibold transition"
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    {{ $user->id === auth()->id() ? 'You' : 'Delete' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-8 text-gray-500">No users found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>

</div>

@endsection
