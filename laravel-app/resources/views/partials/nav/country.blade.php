<div class="mb-8">
    <ul class="nav nav-pills gap-2 flex-nowrap overflow-x-auto pb-1" style="min-width: 0;">
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('countries.*') && !request()->routeIs('countries.show') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('countries.index') }}">
                Countries
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('comparison.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('comparison.index') }}">
                Comparison
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('news.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('news.index') }}">
                News
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('watchlist.*') ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}"
               href="{{ route('watchlist.index') }}">
                Watchlist
            </a>
        </li>
    </ul>
</div>
