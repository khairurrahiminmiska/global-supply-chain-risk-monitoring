<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Supply Chain Risk Monitoring</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->
    <aside class="w-64 min-h-screen bg-slate-800 text-white">

        <div class="p-6 text-xl font-bold border-b border-slate-700">
            🌍 GSCRM
        </div>

        <nav class="mt-5">

            <a href="/dashboard" class="block px-6 py-3 hover:bg-slate-700">
                🏠 Dashboard
            </a>

            <a href="#" class="block px-6 py-3 hover:bg-slate-700">
                🌍 Countries
            </a>

            <a href="#" class="block px-6 py-3 hover:bg-slate-700">
                ⚓ Ports
            </a>

            <a href="#" class="block px-6 py-3 hover:bg-slate-700">
                📰 News
            </a>

            <a href="#" class="block px-6 py-3 hover:bg-slate-700">
                🌦 Weather
            </a>

            <a href="#" class="block px-6 py-3 hover:bg-slate-700">
                📈 Risk Score
            </a>

        </nav>

    </aside>

    <!-- Content -->
    <main class="flex-1">

        <header class="bg-white shadow p-5">

            <div class="flex justify-between">

                <h1 class="text-2xl font-bold">
                    Global Supply Chain Risk Monitoring
                </h1>

                <div>
                    {{ Auth::user()->name }}
                </div>

            </div>

        </header>

        <div class="p-6">

            @yield('content')

        </div>

    </main>

</div>

</body>
</html>