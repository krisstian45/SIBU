@extends('layout')

@section('nav')

    <!-- El tag ul esta en layout.blade.php -->
    @if(Auth::check())
        <li><img class="liIcon" src="{{ asset('images/backend-icon.png') }}" alt="Backend">
            <a href="{{ route('backend') }}">Volver a mi perfil</a>
        </li>
    @else
        <li><img class="liIcon" src="{{ asset('images/login-icon.png') }}" alt="Login">
            <a href="{{ route('login') }}">Iniciar&#xa0;sesión</a>
        </li>
        <li><img class="liIcon" src="{{ asset('images/login-icon.png') }}" alt="Registrarse">
            <a href="{{ route('register') }}">Registrarse</a>
        </li>
    @endif

@endsection

@section('content')
<img style="width: 100%; height: auto;" src="http://hardforo.com/ckeditor_upload/uploads/1448047852_qRMJYIFFD33sbMl.png">
<a style="border: 2px dashed  #ffffff;
box-shadow: 0 0 0 8px #ff0030;
COLOR: black; background-color: lightgreen; font-size: 50px" href="/">VOLVER A INICIO</a>

@endsection

