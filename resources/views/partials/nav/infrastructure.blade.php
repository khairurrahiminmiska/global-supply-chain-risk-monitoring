<div class="mb-8">
    <ul class="nav nav-pills gap-2 flex-nowrap overflow-x-auto pb-1" style="min-width: 0;">
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('ports.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('ports.index') }}">
                Ports
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('weather.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('weather.index') }}">
                Weather
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('business.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('business.index') }}">
                Business
            </a>
        </li>
    </ul>
</div>
