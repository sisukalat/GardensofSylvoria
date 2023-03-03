@php 
$weather = \App\Models\Weather\Weather::where('id', Settings::get('site_weather'))->first();
$season = \App\Models\Weather\WeatherSeason::where('id', Settings::get('site_season'))->first();
@endphp

<div class="card mb-4">
    <div class="card-body text-center">
        The weather is currently...
        <h5 class="card-title">{!! $weather->displayName !!}</h5>
        {!! $weather->summary !!}

        <p>Current Season: {!! $season->displayName !!}</p>
    
    </div>
</div>