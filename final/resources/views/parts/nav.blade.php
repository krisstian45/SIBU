@extends('layout')

@section('nav')

    <li>
        @yield('inner_nav')
    </li>
    <li class="activado">
        <img class="liIcon" src="{{ asset('images/operations-icon.png') }}" alt="Operaciones">
        <a>Operaciones</a>
        <ul>
        @if(Auth::user()->rol_id == '1' or Auth::user()->rol_id == '2')
            <li>
                <img class="liIcon" src="{{ asset('images/food-icon.png') }}" alt="inicio">
                <a href="{{ route('productos') }}">Productos</a>
            </li>
            <li>
                <img class="liIcon" src="{{ asset('images/buy-icon.png') }}" alt="inicio">
                <a href="{{ route('compras') }}">Compras</a>
            </li>
            <li>
                <img class="liIcon" src="{{ asset('images/sell-icon.png') }}" alt="inicio">
                <a href="{{ route('ventas') }}">Ventas</a>
            </li>
            @if(Auth::user()->rol_id == '1')
                <li>
                    <img class="liIcon" src="{{ asset('images/user-icon.png') }}" alt="inicio">
                    <a href="{{ route('usuarios') }}">Usuarios</a>
                </li>
            @endif
            <li>
                <img class="liIcon" src="{{ asset('images/menu-icon.png') }}" alt="inicio">
                <a href="{{ route('menu') }}">Men&uacute; buffet</a>
            </li>
            <li>
                <img class="liIcon" src="{{ asset('images/queue-icon.png') }}" alt="inicio">
                <a href="{{ route('pedidos-administrativo') }}">Pedidos Online</a>
            </li>
        @else
            <li>
                <img class="liIcon" src="{{ asset('images/queue-icon.png') }}" alt="inicio">
                <a href="{{ route('pedidos-cliente') }}">Pedidos Online</a>
            </li>
        @endif
        </ul>
    </li>
    @if(Auth::user()->rol_id == '1' or Auth::user()->rol_id == '2')
        <li class="activado"> <img class="liIcon" src="{{ asset('images/report-icon.png') }}" alt="Listados">
            <a>Listados</a>
            <ul>
                <li>
                    <img class="liIcon" src="{{ asset('images/balance-icon.png') }}" alt="Faltantes">
                    <a href="{{ route('productos-faltantes') }}">Productos faltantes</a>
                </li>
                <li>
                    <img class="liIcon" src="{{ asset('images/balance-icon.png') }}" alt="Stock minimo">
                    <a href="{{ route('productos-stock-minimo') }}">Productos con stock mínimo</a>
                </li>
                <li>
                    <img class="liIcon" src="{{ asset('images/balance-icon.png') }}" alt="Balance ganancias">
                    <a href="{{ route('balance-ganancias') }}">Balance de ganancias</a>
                </li>
                <li>
                    <img class="liIcon" src="{{ asset('images/balance-icon.png') }}" alt="Balance ventas">
                    <a href="{{ route('balance-ventas') }}">Balance de ventas</a>
                </li>
            </ul>
        </li>
    @endif
    @if(Auth::user()->rol_id == '1')
        <li>
            <img class="liIcon" src="{{ asset('images/configuration-icon.png') }}" alt="Configuracion">
            <a href="{{ route('configuracion') }}">Configuraci&oacute;n</a>
        </li>
    @endif
    <li class="user">
        <a class="usuario">Bienvenido, {{ Auth::user()->usuario }}</a>
    </li>
    <li class="user sesion">
        <a href="{{ route('logout') }}">Cerrar sesi&oacute;n</a>
        <img class="liIcon" src="{{ asset('images/bye-icon.png') }}" alt="Salir">
    </li>

@endsection