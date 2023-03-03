@extends('admin.layout')

@section('admin-title') Weather Seasons @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Weather Seasons' => 'admin/weather/seasons']) !!}

<div class="text-right mb-3">
    <a class="btn btn-primary" href="{{ url('admin/weather/weathers') }}"><i class="fas fa-folder"></i> Weather</a>
</div>

<h1>Weather Seasons</h1>

<p>Seasons are groups of weather that will be rolled on during their respective season. This will roll a random weather from the contents of the season.</p>

<div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/weather/seasons/create') }}"><i class="fas fa-plus"></i> Create New Season</a></div>
@if(!count($seasons))
    <p>No loot seasons found.</p>
@else
      <div class="row ml-md-2">
        <div class="d-flex row flex-wrap col-12 pb-1 px-0 ubt-bottom">
          <div class="col-3 col-md-2 font-weight-bold">ID</div>
          <div class="col-3 col-md-4 font-weight-bold">Name</div>
          <div class="col-6 col-md-5 font-weight-bold">Display Name</div>
        </div>
        @foreach($seasons as $season)
        <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-top">
          <div class="col-3 col-md-2 ">#{{ $season->id }}</div>
          <div class="col-3 col-md-4">{{ $season->name }}</div>
          <div class="col-3 col-md-5">{!! $season->display_name !!}</div>
          <div class="col-3 col-md-1 text-right"><a href="{{ url('admin/weather/seasons/edit/'.$season->id) }}" class="btn btn-primary py-0 px-2">Edit</a></div>
        </div>
        @endforeach
      </div>
@endif

@endsection
