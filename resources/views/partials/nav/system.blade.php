<div class="mb-8">
    <ul class="nav nav-pills gap-2 flex-nowrap overflow-x-auto pb-1" style="min-width: 0;">
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('monitoring.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('monitoring.index') }}">
                Activity
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('system.health') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('system.health') }}">
                Health
            </a>
        </li>
        @if(Auth::user()?->role === 'admin')
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('admin.index') }}">
                Admin
            </a>
        </li>
        @endif
    </ul>
</div>
