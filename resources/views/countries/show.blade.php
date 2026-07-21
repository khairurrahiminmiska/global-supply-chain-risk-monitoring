@extends('layouts.main')

@section('content')

@include('partials.nav.country')

<div class="space-y-6">

    @include('countries.partials.info-card')

    @include('countries.partials.exchange-card')

    @include('countries.partials.economy-card')

    @include('countries.partials.news-card')

    @include('countries.partials.weather-card')

    @include('countries.partials.risk-card')

</div>

@endsection