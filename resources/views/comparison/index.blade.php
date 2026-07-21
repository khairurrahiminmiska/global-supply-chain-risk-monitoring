@extends('layouts.main')

@section('content')

@include('partials.nav.country')

<div class="container mx-auto p-6">

<h1 class="text-3xl font-bold mb-6">
    Country Comparison
</h1>

<form method="GET">

<div class="grid grid-cols-2 gap-6">

<div>

<label>Country A</label>

<select
    name="country_a"
    class="w-full border rounded p-2">

    @foreach($countries as $country)

    <option
        value="{{ $country->id }}"
        @if(request('country_a')==$country->id) selected @endif>

        {{ $country->name }}

    </option>

    @endforeach

</select>

</div>

<div>

<label>Country B</label>

<select
    name="country_b"
    class="w-full border rounded p-2">

    @foreach($countries as $country)

    <option
        value="{{ $country->id }}"
        @if(request('country_b')==$country->id) selected @endif>

        {{ $country->name }}

    </option>

    @endforeach

</select>

</div>

</div>

<button
    class="mt-5 bg-emerald-600 text-white px-5 py-2 rounded">

    Compare

</button>

</form>

@if($countryA && $countryB)

<table class="table-auto w-full mt-8 border">

<thead class="bg-gray-100">

<tr>

    <th class="border p-2">Indicator</th>

    <th class="border p-2">{{ $countryA->name }}</th>

    <th class="border p-2">{{ $countryB->name }}</th>

</tr>

</thead>

<tbody>

<tr>
    <td class="border p-2">GDP (USD)</td>
    <td class="border p-2">{{ $countryA->gdp ? number_format($countryA->gdp, 0, '.', ',') : '-' }}</td>
    <td class="border p-2">{{ $countryB->gdp ? number_format($countryB->gdp, 0, '.', ',') : '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Inflation</td>
    <td class="border p-2">{{ $countryA->inflation ? $countryA->inflation.'%' : '-' }}</td>
    <td class="border p-2">{{ $countryB->inflation ? $countryB->inflation.'%' : '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Exports (USD)</td>
    <td class="border p-2">{{ $countryA->exports ? number_format($countryA->exports, 0, '.', ',') : '-' }}</td>
    <td class="border p-2">{{ $countryB->exports ? number_format($countryB->exports, 0, '.', ',') : '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Imports (USD)</td>
    <td class="border p-2">{{ $countryA->imports ? number_format($countryA->imports, 0, '.', ',') : '-' }}</td>
    <td class="border p-2">{{ $countryB->imports ? number_format($countryB->imports, 0, '.', ',') : '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Exchange Rate (vs USD)</td>
    @php
        $rateA = $countryA->exchangeRates->sortByDesc('retrieved_at')->first();
        $rateB = $countryB->exchangeRates->sortByDesc('retrieved_at')->first();
    @endphp
    <td class="border p-2">{{ $rateA ? $rateA->target_currency.' '.$rateA->rate : '-' }}</td>
    <td class="border p-2">{{ $rateB ? $rateB->target_currency.' '.$rateB->rate : '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Weather</td>
    <td class="border p-2">{{ optional($countryA->weather)->condition_label ?? '-' }}</td>
    <td class="border p-2">{{ optional($countryB->weather)->condition_label ?? '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Temperature</td>
    <td class="border p-2">{{ optional($countryA->weather)->temperature ? optional($countryA->weather)->temperature.'C' : '-' }}</td>
    <td class="border p-2">{{ optional($countryB->weather)->temperature ? optional($countryB->weather)->temperature.'C' : '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Storm Risk</td>
    <td class="border p-2">{{ optional($countryA->weather)->storm_risk ?? '-' }}</td>
    <td class="border p-2">{{ optional($countryB->weather)->storm_risk ?? '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Risk Score</td>
    <td class="border p-2">{{ optional($countryA->riskScore)->total_score ?? '-' }}</td>
    <td class="border p-2">{{ optional($countryB->riskScore)->total_score ?? '-' }}</td>
</tr>

<tr>
    <td class="border p-2">Risk Level</td>
    <td class="border p-2">{{ optional($countryA->riskScore)->risk_level ?? '-' }}</td>
    <td class="border p-2">{{ optional($countryB->riskScore)->risk_level ?? '-' }}</td>
</tr>

</tbody>

</table>

@endif

</div>

@endsection
