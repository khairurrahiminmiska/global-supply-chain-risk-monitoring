<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>GSCRM — Global Risk Intelligence</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-[#F7FAF8] text-[#18251E] antialiased">

<div class="min-h-screen">

    {{-- ========================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================================= --}}

    <aside
        class="fixed inset-y-0 left-0 z-40 w-72
               bg-white border-r border-[#E5ECE7]
               flex flex-col"
    >

        {{-- BRAND --}}

        <div class="h-24 px-7 flex items-center border-b border-[#EEF3EF]">

            <div
                class="w-11 h-11 rounded-2xl
                       bg-[#16803C]
                       flex items-center justify-center
                       shadow-sm shadow-green-200"
            >
                <svg
                    class="w-6 h-6 text-white"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M12 3v18m0-18c-3 3-5 6-5 9s2 6 5 9m0-18c3 3 5 6 5 9s-2 6-5 9M3 12h18"
                    />
                </svg>
            </div>

            <div class="ml-4">

                <h1 class="text-xl font-bold tracking-tight text-[#14532D]">
                    GSCRM
                </h1>

                <p class="text-xs text-[#718078] mt-0.5">
                    Global Risk Intelligence
                </p>

            </div>

        </div>


        {{-- NAVIGATION --}}

        <nav class="flex-1 overflow-y-auto px-4 py-7 space-y-1">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition duration-200
               {{ request()->routeIs('dashboard')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
               }}">
                <span>Command Center</span>
            </a>

            <a href="{{ route('countries.index') }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition duration-200
               {{ request()->routeIs('countries.*') || request()->routeIs('comparison.*') || request()->routeIs('news.*') || request()->routeIs('watchlist.*')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
               }}">
                <span>Country Intelligence</span>
            </a>

            <a href="{{ route('risk.index') }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition duration-200
               {{ request()->routeIs('risk.*') || request()->routeIs('risk-alerts.*') || request()->routeIs('risk.analytics') || request()->routeIs('risk.map')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
               }}">
                <span>Risk Center</span>
            </a>

            <a href="{{ route('ports.index') }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition duration-200
               {{ request()->routeIs('ports.*') || request()->routeIs('weather.*') || request()->routeIs('business.*')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
               }}">
                <span>Infrastructure</span>
            </a>

            <a href="{{ route('monitoring.index') }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition duration-200
               {{ request()->routeIs('monitoring.*') || request()->routeIs('system.health') || request()->routeIs('admin.*')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
               }}">
                <span>System</span>
            </a>

        </nav>


        {{-- MONITORING STATUS --}}

        <div class="p-5">

            <div
                class="rounded-2xl
                       bg-[#F2FBF5]
                       border border-[#DDF3E4]
                       p-4"
            >

                <div class="flex items-center gap-3">

                    <div class="relative">

                        <span
                            class="block w-2.5 h-2.5
                                   rounded-full bg-[#22A447]"
                        ></span>

                        <span
                            class="absolute inset-0
                                   rounded-full bg-[#22A447]
                                   animate-ping opacity-30"
                        ></span>

                    </div>

                    <p class="text-sm font-semibold text-[#14532D]">
                        Monitoring Active
                    </p>

                </div>

                <p class="text-xs text-[#718078] mt-2 leading-5">
                    Global risk intelligence engine is currently online.
                </p>

            </div>

        </div>

    </aside>


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <div class="ml-72 min-h-screen">

        {{-- HEADER --}}

        <header
            class="sticky top-0 z-30
                   h-24 bg-white/90 backdrop-blur-xl
                   border-b border-[#E5ECE7]"
        >

            <div
                class="h-full px-10
                       flex items-center justify-between"
            >

                <div>

                    <p
                        class="text-xs font-semibold
                               uppercase tracking-[0.16em]
                               text-[#16803C]"
                    >
                        Supply Chain Intelligence
                    </p>

                    <h2
                        class="text-xl font-bold
                               text-[#18251E] mt-1"
                    >
                        Global Risk Monitoring System
                    </h2>

                </div>


                <div class="flex items-center gap-6">

                    {{-- LIVE STATUS --}}

                    <div
                        class="hidden lg:flex items-center gap-2
                               px-4 py-2 rounded-full
                               bg-[#F2FBF5]
                               border border-[#DDF3E4]"
                    >

                        <span
                            class="w-2 h-2 rounded-full
                                   bg-[#22A447]"
                        ></span>

                        <span
                            class="text-xs font-semibold
                                   text-[#16803C]"
                        >
                            Live Monitoring
                        </span>

                    </div>


                    <div class="h-9 w-px bg-[#E5ECE7]"></div>


                    {{-- USER --}}

                    <div class="flex items-center gap-3">

                        <div class="text-right hidden sm:block">

                            <p
                                class="text-sm font-semibold
                                       text-[#18251E]"
                            >
                                {{ Auth::user()?->name ?? 'Administrator' }}
                            </p>

                            <p class="text-xs text-[#89958E] mt-0.5">
                                {{ ucfirst(Auth::user()?->role ?? 'user') }}
                            </p>

                        </div>


                        <div
                            class="w-11 h-11 rounded-2xl
                                   bg-[#ECFDF3]
                                   border border-[#DDF3E4]
                                   text-[#16803C]
                                   flex items-center justify-center
                                   font-bold"
                        >
                            {{ strtoupper(
                                substr(
                                    Auth::user()?->name ?? 'Administrator',
                                    0,
                                    1
                                )
                            ) }}
                        </div>

                    </div>

                </div>

            </div>

        </header>


        {{-- PAGE CONTENT --}}

        <div id="toast-container" class="fixed top-4 right-4 z-50 max-w-sm"></div>

        <main class="px-10 py-9">

            @if(session('success'))

                <div
                    class="mb-7 px-5 py-4
                           bg-[#F0FDF4]
                           border border-[#D4F0DC]
                           rounded-2xl
                           text-[#16803C]
                           text-sm font-medium"
                >
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div
                    class="mb-7 px-5 py-4
                           bg-red-50
                           border border-red-100
                           rounded-2xl
                           text-red-600
                           text-sm font-medium"
                >
                    {{ session('error') }}
                </div>

            @endif


            @yield('content')

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>