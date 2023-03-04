@extends('layouts.app')

@section('title') Home @endsection

@section('content')
    @if(Auth::check())
        @include('pages._dashboard')
    @else
        @include('pages._logged_out')
    @endif
@endsection

{{-- default is set to 0 so it wont show up if not wanted or admins arent ready yet --}}
@if(!Settings::get('site_weather') == 0 && !Settings::get('site_season')== 0)
@section('sidebar')
    @include('widgets._current_weather')
@endsection
@endif