@extends('layouts.main')

@section('content')

@include('partials.nav.system')

<div class="space-y-8">

    <div>
        <h1 class="text-4xl font-bold text-slate-800">Manage Ports</h1>
        <p class="text-gray-500 mt-2">All port dataset entries in the system</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-5 py-3 text-left">Name</th>
                        <th class="px-5 py-3 text-left">Country</th>
                        <th class="px-5 py-3 text-left">Harbor Size</th>
                        <th class="px-5 py-3 text-left">Type</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($ports as $port)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="px-5 py-4 font-medium">{{ $port->name }}</td>
                        <td class="px-5 py-4 text-gray-600">{{ $port->country?->name ?? $port->country_code }}</td>
                        <td class="px-5 py-4">{{ $port->harbor_size ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $port->harbor_type ?? '-' }}</td>
                        <td class="px-5 py-4">
                            <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $port->status === 'active' ? 'bg-green-50 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $port->status ?? 'unknown' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <form action="{{ route('admin.ports.destroy', $port) }}" method="POST"
                                  onsubmit="return confirm('Delete this port?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-8 text-gray-500">No ports found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $ports->links() }}
        </div>
    </div>

</div>

@endsection
