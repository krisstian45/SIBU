@extends('layout')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">

@endsection

@section('nav')

    <li>
        <img class="liIcon" src="{{ asset('images/home-icon.png') }}" alt="Frontend">
        <a href="{{ route('frontend') }}">Inicio</a>
    </li>

@endsection

@section('content')

    <section class="principal">
        <h2>Iniciar sesi&oacute;n</h2>
        <div class="login-page">
            <div class="form">
                <!-- Laravel genera el token para evitar CSRF automaticamente -->
                {!! Form::open(['route' => 'login', 'method' => 'POST', 'class' => 'login-form']) !!}

                    <!-- Mensaje de error -->
                    @include('errors/errors')

                    <br>

                    <input type="text" placeholder="Nombre de usuario" class="input" name="usuario" pattern=".{2,20}" required="required" title="mínimo 2 carácteres, máximo 20" id="usuario" autofocus>

                    <br>
                    <br>

                    <input type="password" placeholder="Contraseña" class="input" name="password" pattern=".{6,30}" required="required" title="mínimo 6 carácteres, máximo 30" id="password">

                    <br>
                    <br>

                    <button>Ingresar</button>

                {!! Form::close() !!}

                <br>

                <p class="message"><a href="#">Olvidé mi cuenta</a></p>
                <p class="message"><a href="{{ route('register') }}">Registrarse</a></p>
            </div>
        </div>
    </section>

@endsection