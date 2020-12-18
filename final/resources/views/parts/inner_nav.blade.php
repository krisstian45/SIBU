@extends('parts/nav')

@section('inner_nav')

	<li><img class="liIcon" src="{{ asset('images/backend-icon.png') }}" alt="inicio">
    	<a href="{{ route('backend') }}">Volver</a>
    </li>

@endsection