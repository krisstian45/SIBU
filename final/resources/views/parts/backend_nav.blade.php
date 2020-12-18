@extends('parts/nav')

@section('inner_nav')

	<li>
	    <img class="liIcon" src="{{ asset('images/home-icon.png') }}" alt="Inicio">
	    <a id="home" href="{{ route('frontend') }}">Inicio</a>
	</li>

@endsection