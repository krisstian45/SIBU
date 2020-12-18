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

    <section class="principal">
        <article>

            <br>

            Titulo: {{ $config->titulo }}

            <br>

            Descripción: {{ $config->descripcion }}

            <br>

            Email: {{ $config->email }}

            <br>

        </article>
        @if($menu)
            <article>
                <h3>Menu del dia: {{ date('d-m-Y', strtotime($menu[0]->fecha)) }}</h3>

                <br>

                @foreach($menu as $producto)
                    <p class="menuDia">{{ $producto->nombre_producto }}</p>
                @endforeach
            </article>
        @else
            <article><h3>Aún no hay menú. Disculpe las molestias.</h3></article>
        @endif
    </section>

    <aside>

        <br>
        <br>

        <h2>Subscribite a nuestro canal de telegram!</h2>
        <p>Enterate del menú del día de hoy y mañana: </p>
        <a style="color:blue" href="#" onclick=openInNewTab("https://web.telegram.org/#/im?p=@BuffetGrupo46_bot")>@BuffetGrupo46</a>
    </aside>

@endsection