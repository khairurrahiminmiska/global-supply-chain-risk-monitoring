@extends('layouts.main')

@section('content')

@include('partials.nav.system')

<div class="space-y-8">

    <div>
        <h1 class="text-4xl font-bold text-slate-800">
            Admin Dashboard
        </h1>
        <p class="text-gray-500 mt-2">
            Manage users, port datasets, and analysis articles
        </p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-5">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <p class="text-gray-500 text-sm">Users</p>
            <h2 class="text-4xl font-bold text-slate-800 mt-2">{{ $stats['users'] }}</h2>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <p class="text-gray-500 text-sm">Countries</p>
            <h2 class="text-4xl font-bold text-slate-800 mt-2">{{ $stats['countries'] }}</h2>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <p class="text-gray-500 text-sm">Ports</p>
            <h2 class="text-4xl font-bold text-slate-800 mt-2">{{ $stats['ports'] }}</h2>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <p class="text-gray-500 text-sm">Articles</p>
            <h2 class="text-4xl font-bold text-slate-800 mt-2">{{ $stats['articles'] }}</h2>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <p class="text-gray-500 text-sm">News</p>
            <h2 class="text-4xl font-bold text-slate-800 mt-2">{{ $stats['news'] }}</h2>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.users') }}"
           class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition border-l-4 border-blue-500">
            <h3 class="font-bold text-lg text-slate-800">Manage Users</h3>
            <p class="text-gray-500 text-sm mt-2">View, manage and remove registered users</p>
        </a>
        <a href="{{ route('admin.ports') }}"
           class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition border-l-4 border-emerald-500">
            <h3 class="font-bold text-lg text-slate-800">Manage Ports</h3>
            <p class="text-gray-500 text-sm mt-2">View and delete port dataset entries</p>
        </a>
        <a href="{{ route('admin.articles.index') }}"
           class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition border-l-4 border-purple-500">
            <h3 class="font-bold text-lg text-slate-800">Manage Articles</h3>
            <p class="text-gray-500 text-sm mt-2">Create and manage analysis articles</p>
        </a>
    </div>

    {{-- Latest Users --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-xl text-slate-800">Latest Users</h2>
            <a href="{{ route('admin.users') }}" class="text-blue-600 hover:underline text-sm font-semibold">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-5 py-3 text-left">Name</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-left">Role</th>
                        <th class="px-5 py-3 text-left">Registered</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($latestUsers as $user)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="px-5 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-5 py-4 text-gray-600">{{ $user->email }}</td>
                        <td class="px-5 py-4">
                            <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-sm">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-8 text-gray-500">No users found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
