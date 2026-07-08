<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Global Supply Chain Risk Monitoring</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-800 text-white fixed h-screen">

        <div class="p-6 text-2xl font-bold border-b border-slate-700">

            🌍 GSCRM

        </div>

        <nav class="mt-6">

            <a href="{{ route('dashboard') }}"
               class="block px-6 py-3 hover:bg-slate-700">

                🏠 Dashboard

            </a>

            <a href="{{ route('countries.index') }}"
               class="block px-6 py-3 hover:bg-slate-700">

                🌍 Countries

            </a>

            <a href="#"
               class="block px-6 py-3 hover:bg-slate-700">

                ⚓ Ports

            </a>

            <a href="#"
               class="block px-6 py-3 hover:bg-slate-700">

                📰 News

            </a>

            <a href="#"
               class="block px-6 py-3 hover:bg-slate-700">

                🌦 Weather

            </a>

            <a href="#"
               class="block px-6 py-3 hover:bg-slate-700">

                📈 Risk Score

            </a>

        </nav>

    </aside>

    <!-- Content -->
    <div class="flex-1 ml-64">

        <!-- Header -->
        <header class="bg-white shadow">

            <div class="flex justify-between items-center px-8 py-5">

                <h1 class="text-2xl font-bold">

                    Global Supply Chain Risk Monitoring

                </h1>

                <div class="flex items-center gap-3">

                    <div class="text-right">

                        <p class="font-semibold">

                            {{ Auth::user()->name }}

                        </p>

                        <p class="text-sm text-gray-500">

                            Administrator

                        </p>

                    </div>

                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center">

                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                    </div>

                </div>

            </div>

        </header>

        <!-- Main -->
        <main class="p-8">

            @yield('content')

        </main>

    </div>

</div>

</body>

</html>