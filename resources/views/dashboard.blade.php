@extends('layouts.main')

@section('content')

<div class="bg-white rounded-xl shadow p-5">

    <h2 class="text-gray-500">
        🌍 Countries
    </h2>

    <h1 class="text-5xl font-bold mt-4">

        {{ $totalCountries }}

    </h1>

</div>

   <div class="bg-white rounded-xl shadow p-5">

    <h2 class="text-gray-500">
        💱 Exchange Rate
    </h2>

    <h1 class="text-3xl font-bold mt-4 text-green-600">

        Active

    </h1>

</div>

   <div class="bg-white rounded-xl shadow p-5">

    <h2 class="text-gray-500">
        📰 News
    </h2>

    <h1 class="text-xl font-bold mt-4 text-yellow-600">

        Coming Soon

    </h1>

</div>

    <div class="bg-white rounded-xl shadow p-5">

    <h2 class="text-gray-500">
        📈 Risk Score
    </h2>

    <h1 class="text-xl font-bold mt-4 text-gray-500">

        Coming Soon

    </h1>

</div>

@endsection
