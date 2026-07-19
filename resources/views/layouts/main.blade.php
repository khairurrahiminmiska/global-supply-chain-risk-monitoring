<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>GSCRM — Global Risk Intelligence</title>

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

        <nav class="flex-1 overflow-y-auto px-4 py-7">

            {{-- OVERVIEW --}}

            <p
                class="px-4 mb-3 text-[11px] font-bold
                       tracking-[0.18em] text-[#9AA8A0]"
            >
                OVERVIEW
            </p>


            {{-- DASHBOARD --}}

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl mb-1
                transition duration-200
                {{ request()->routeIs('dashboard')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
                }}"
            >

                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M4 5a1 1 0 011-1h5v6H4V5zm10-1h5a1 1 0 011 1v9h-6V4zM4 14h6v6H5a1 1 0 01-1-1v-5zm10 4h6v1a1 1 0 01-1 1h-5v-2z"
                    />
                </svg>

                <span>
                    Command Center
                </span>

            </a>


            {{-- COUNTRIES --}}

            <a
                href="{{ route('countries.index') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl mb-1
                transition duration-200
                {{ request()->routeIs('countries.*')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
                }}"
            >

                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke-width="1.8"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-width="1.8"
                        d="M3 12h18M12 3c2.5 2.5 4 5.5 4 9s-1.5 6.5-4 9c-2.5-2.5-4-5.5-4-9s1.5-6.5 4-9z"
                    />
                </svg>

                <span>
                    Countries
                </span>

            </a>


            {{-- PORTS --}}

            <a
                href="{{ route('ports.index') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl mb-1
                transition duration-200
                {{ request()->routeIs('ports.*')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
                }}"
            >

                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M3 17l2 2h14l2-2M5 17l2-8h10l2 8M9 9V5h6v4M12 5V3"
                    />
                </svg>

                <span>
                    Port Network
                </span>

            </a>

            <a href="{{ route('business.index') }}"
   class="flex items-center gap-3 px-5 py-3 rounded-xl transition
   {{ request()->routeIs('business.*')
        ? 'bg-emerald-50 text-emerald-700 font-semibold'
        : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-700'
   }}">

    <span>📊</span>

    <span>
        Business Intelligence
    </span>

</a>

            {{-- INTELLIGENCE --}}

            <p
                class="px-4 mt-8 mb-3 text-[11px] font-bold
                       tracking-[0.18em] text-[#9AA8A0]"
            >
                INTELLIGENCE
            </p>
            
            <a href="{{ route('comparison.index') }}"
   class="flex items-center gap-3 px-5 py-3 rounded-xl transition
   {{ request()->routeIs('comparison.*')
        ? 'bg-emerald-50 text-emerald-700 font-semibold'
        : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-700'
   }}">

    <span>⚖️</span>

    <span>Country Comparison</span>

</a>

            {{-- NEWS --}}

<a
    href="{{ route('news.index') }}"
    class="flex items-center gap-3 px-5 py-3 rounded-xl transition
    {{ request()->routeIs('news.*')
        ? 'bg-emerald-50 text-emerald-700 font-semibold'
        : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-700'
    }}"
>

    <svg
        class="w-5 h-5"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.8"
            d="M5 4h11a2 2 0 012 2v13H7a2 2 0 01-2-2V4zm13 4h1a2 2 0 012 2v7a2 2 0 01-2 2h-1M8 8h7M8 12h7M8 16h4"
        />
    </svg>

    <span>
        News Intelligence
    </span>

</a>

            {{-- WEATHER --}}

            <a href="{{ route('weather.index') }}"
   class="flex items-center gap-3 px-5 py-3 rounded-xl transition
   {{ request()->routeIs('weather.*')
        ? 'bg-emerald-50 text-emerald-700 font-semibold'
        : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-700'
   }}">

    <span>🌦️</span>

    <span>
        Weather Monitor
    </span>

</a>


            {{-- RISK SCORE --}}

            <a
                href="{{ route('risk.index') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl mb-1
                transition duration-200
                {{ request()->routeIs('risk.*')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
                }}"
            >

                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M4 18V9m5 9V5m5 13v-7m5 7V3"
                    />
                </svg>

                <span>
                    Risk Intelligence
                </span>

            </a>


            {{-- RISK ALERTS --}}

            <a
                href="{{ route('risk-alerts.index') }}"
                class="flex items-center justify-between px-4 py-3.5 rounded-xl mb-1
                transition duration-200
                {{ request()->routeIs('risk-alerts.*')
                    ? 'bg-[#ECFDF3] text-[#16803C] font-semibold'
                    : 'text-[#66736B] hover:bg-[#F4F8F5] hover:text-[#16803C]'
                }}"
            >

                <div class="flex items-center gap-3">

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"
                        />
                    </svg>

                    <span>
                        Risk Alerts
                    </span>

                </div>


                @if(($unreadRiskAlerts ?? 0) > 0)

                    <span
                        class="min-w-6 h-6 px-2 rounded-full
                               bg-[#DC4C4C] text-white
                               text-[11px] font-bold
                               flex items-center justify-center"
                    >
                        {{ $unreadRiskAlerts > 99
                            ? '99+'
                            : $unreadRiskAlerts
                        }}
                    </span>

                @endif

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
                                System Administrator
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

</body>

</html>