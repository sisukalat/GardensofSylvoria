@extends('world.layout')

@section('title') Weather Forecast @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Weather' => 'world/weathers', 'Weather Forecast' => 'world/forecast']) !!}
<h1>Weather Forecast</h1>

@php 
$weather = \App\Models\Weather\Weather::where('id', Settings::get('site_weather'))->first();
$season = \App\Models\Weather\WeatherSeason::where('id', Settings::get('site_season'))->first();
@endphp
<br>
@if(!Settings::get('site_weather') == 0 && !Settings::get('site_season')== 0)
<h4>The weather is currently...</h4>
    <div class="card mb-3">
        <div class="card-body">
        @include('world._weather_entry', ['imageUrl' => $weather->imageUrl, 'name' => $weather->displayName, 'description' => $weather->parsed_description, 'searchUrl' => $weather->searchUrl, 'weather' => $weather])
        </div>
    </div>
<h4>And the season is currently...</h4>
    <div class="card mb-3">
        <div class="card-body">
        @include('world._season_entry', ['name' => $season->name])
        </div>
    </div>
@else
Looks like we don't have any data for the weather at the moment... stay tuned!
@endif
@endsection