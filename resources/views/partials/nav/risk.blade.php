<div class="mb-8">
    <ul class="nav nav-pills gap-2 flex-nowrap overflow-x-auto pb-1" style="min-width: 0;">
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('risk.index') || request()->routeIs('risk.show') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('risk.index') }}">
                Scores
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('risk-alerts.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('risk-alerts.index') }}">
                Alerts
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('risk.analytics') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('risk.analytics') }}">
                Analytics
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('risk.map') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('risk.map') }}">
                Map
            </a>
        </li>
    </ul>
</div>
